<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Secteur;
use App\Entity\ProduitDD;
use App\Entity\KitBaseSecu;
use App\Entity\ProduitSecu;
use App\Services\PdfExport;
use App\Entity\ProduitFavori;
use App\Services\FileHandler;
use App\Services\ExcelService;
use App\Entity\UserTransaction;
use App\Form\KitBaseFilterType;
use App\Form\RetraitFilterType;
use App\Services\SearchService;
use App\Entity\ImplantationAroma;
use App\Entity\ProduitSecuFavori;
use App\Form\MyProduitFilterType;
use App\Repository\UserRepository;
use App\Form\MyProduitDDFilterType;
use App\Services\OrderServiceAroma;
use App\Util\Search\MyCriteriaParam;
use App\Form\MyProduitSecuFilterType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ImplantationAromaFilterType;
use App\Repository\KitBaseSecuRepository;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\AgentSecteurRepository;
use App\Repository\ProduitFavoriRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\KitBaseElmtSecuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProduitSecuFavoriRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/transaction")
 */
class AdminTransactionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager,
        private ExcelService $excelService,
        private PdfExport $pdfExport
    ){

    }

    /**
     * @Route("/retrait", name="admin_retrait_list")
     */
    public function retrait(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $action = $request->get('action_button');
        $page = $request->query->get('page', 1);
        $limit = 20;
        $criteria = [
            ['prop' => 'status'],
            ['prop' => 'dateMin', 'col' => 'createdAt', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'createdAt', 'op' => '<='],
            ['prop' => 'userName', 'col' => "concat(concat(coalesce(u.prenom, ''), ' '), u.nom)", 'alias' => null, 'op' => 'LIKE'],
            ['prop' => 'rib', 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(RetraitFilterType::class, $filter, [
            'method' => 'GET',
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();
        

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('ut')
            ->from(UserTransaction::class, 'ut')
            ->join('ut.user', 'u')
            ->leftjoin('ut.secteur', 's')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'ut')); 
        $where["where"] .= " and ut.type = :typeRetrait ";  
        $where["params"]['typeRetrait'] = UserTransaction::TYPE_RETRAIT;
        $query->where($where["where"]);
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'ut.createdAt', 'direction' => 'desc']);

        if(!empty($action) && $action != 'search_action'){
            return $this->export($query->getQuery()->getResult(),$action);
        }

        $data = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/admin/transaction/retrait_list.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
        ]);
    }

    // 'validated'|'denied'
    /**
     * @Route("/retrait/{id}/status/{status}", name="admin_retrait_status", methods={"POST"})
     */
    public function changeStatus(Request $request, UserTransaction $userTransaction, string $status): Response
    {
        if($status === 'validated' || $status === 'denied'){
            try{
                $userTransaction->setStatus($status === 'validated' ? UserTransaction::STATUS_VALID : UserTransaction::STATUS_CANCELLED);
                $this->entityManager->persist($userTransaction);
                $this->entityManager->flush();
                $this->addFlash('success', 'Retrait '.($status === 'validated' ? 'validé':'refusé').' avec succès'); 
            } catch(Exception $ex){
                $this->addFlash('danger',$ex->getMessage());
            } 
        }
        return $this->redirectToRoute('admin_retrait_list');
    }

    public function export($data,$action): Response
    {
        
         try{
            $common_file_name = 'liste-retraits';
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = ["Date", "Montant","Utilisateur","Secteur","RIB", "Statut"];
                $fields = [
                    "createdAtStr",
                    "user.fullName",
                    "secteur.nom",
                    "amount",
                    "rib",
                    "statusRetraitStr"
                ];
                $file = $this->excelService->export($data, $fields, $headers);
    
                $name = $common_file_name."-$date.csv";

                return new BinaryFileResponse($file, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$name\"",
                ]);
            }
            elseif($action == 'excel'){
                $headers = ["Date", "Montant","Utilisateur","Secteur","RIB", "Statut"];
                $fields = [
                    "createdAtStr",
                    "user.fullName",
                    "secteur.nom",
                    "amount",
                    "rib",
                    "statusRetraitStr"
                ];
                $spreadsheet = $this->excelService->exportXlsx($data, $fields, $headers);
        
             
                $name = $name = $common_file_name."-$date.xlsx";

                $writer = new Xlsx($spreadsheet);
            
                $response = new Response();
            
                // Set headers for the file download
                $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->headers->set('Content-Disposition', 'attachment;filename="' . $name . '"');
                $response->headers->set('Cache-Control', 'max-age=0'); // Ensure the file is not cached
            
                ob_start();
                $writer->save('php://output');
                $content = ob_get_clean();
                $response->setContent($content);
        
                return $response;
            
            }
            elseif($action == "pdf"){
                $headers = [
                    ['name' =>"Date"],
                    ['name' =>"Utilisateur"],
                    ['name' =>"Secteur"],
                    ['name' =>"Montant"], 
                    ['name' =>"RIB"], 
                    ['name' =>"Statut"]
                ];
                $fields = [
                    ['name' => "createdAtStr", 'class' => "text-center"],
                    ['name' => "user.fullName", 'class' => "text-left"],
                    ['name' => "secteur.nom", 'class' => "text-left"],
                    ['name' => "amount", 'class' => "text-end","symbol" => "€"],
                    ['name' => "rib",'class' => "text-center"],
                    ['name' => "statusRetraitStr"],
                ];
                $pdf = $this->pdfExport->generateGenericPDF("Liste des retraits",$data,$headers,$fields);

                $fileName = $common_file_name."-$date.pdf";
                $response = new Response($pdf);
                $response->headers->set('Content-Type', 'application/pdf');
                $response->headers->set('Content-Disposition', 'attachment; filename="'.$fileName.'"');
        
                return $response;

            }
        } 
        catch (Exception $ex) {
            $this->addFlash(
                'danger',
                $_ENV['CUSTOM_ERROR_MESSAGE']
            );
        }
        return $this->redirectToRoute('admin_retrait_list');

    }
}
