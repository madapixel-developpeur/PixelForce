<?php

namespace App\Controller;

use Exception;
use App\Services\PdfExport;
use App\Manager\EntityManager;
use App\Services\ExcelService;
use App\Entity\CategorieFormation;
use App\Form\CategorieFormationType;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Form\CategorieFormationSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieFormationRepository;
use App\Entity\SearchEntity\CategorieFormationSearch;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCategorieFormationController extends AbstractController
{
    protected $repoCatFormation;

    protected $entityManager;

    public function __construct(CategorieFormationRepository $repoCatFormation, EntityManager $entityManager,
        private ExcelService $excelService,
        private PdfExport $pdfExport)
    {
        $this->repoCatFormation = $repoCatFormation;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/formation/categorie/liste", name="admin_formation_categorie_list")
     */
    public function admin_formation_categorie_list(Request $request, PaginatorInterface $paginator): Response
    {
        $action = $request->get('action_button');
        $search = new CategorieFormationSearch();
        $searchForm = $this->createForm(CategorieFormationSearchType::class, $search)
            ->remove('ordre');
        $searchForm->handleRequest($request);
        if(!empty($action) && $action != 'search_action'){
            return $this->export($this->repoCatFormation->findCategorieFormationQuery($search),$action);
        }
        
        $categories = $paginator->paginate(
            $this->repoCatFormation->findCategorieFormationQuery($search),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/formation/category/list_categories.html.twig', [
            'categories' => $categories,
            'searchForm' => $searchForm->createView()
        ]);
    }


    /**
     * @Route("/admin/formation/categorie/add", name="admin_formation_categorie_add")
     */
    public function admin_formation_categorie_add(Request $request)
    {
        $category = new CategorieFormation();
        $formCat = $this->createForm(CategorieFormationType::class, $category)->remove('ordreCatFormation');
        
        $formCat->handleRequest($request);
        if ($formCat->isSubmitted() && $formCat->isValid()) {
            $categories = $this->repoCatFormation->findAll();
            if(count($categories) === 0){
                $category->setOrdreCatFormation(1);
            }else{
                $lastOrderCat = $this->repoCatFormation->findBy([],['id'=>'DESC'],1,0);
                $newOrderCat = $lastOrderCat[0]->getOrdreCatFormation() + 1;
                $category->setOrdreCatFormation($newOrderCat);
            }
            $this->entityManager->save($category);
            $this->addFlash('success', "Catégorie ajoutée avec succès");
            return $this->redirectToRoute('admin_formation_categorie_list');    
        }

        return $this->render('user_category/admin/formation/category/add_category.html.twig', [
            'formCat' => $formCat->createView(),          
        ]);    
    }

    /**
     * @Route("/admin/formation/categorie/{id}/edit", name="admin_formation_categorie_edit")
     */
    public function admin_formation_categorie_edit(CategorieFormation $category, Request $request)
    {
        $formCat = $this->createForm(CategorieFormationType::class, $category);
        
        $formCat->handleRequest($request);
        if ($formCat->isSubmitted() && $formCat->isValid()) {
            $lastOrderCat = $this->repoCatFormation->findBy([],['id'=>'DESC'],1,0);
            $lastOrderCat = $lastOrderCat[0]->getOrdreCatFormation() + 1;
            $this->entityManager->save($category);
            $this->addFlash('success', "Catégorie modifiée avec succès");
            return $this->redirectToRoute('admin_formation_categorie_list');    
        }

        return $this->render('user_category/admin/formation/category/add_category.html.twig', [
            'formCat' => $formCat->createView(),
            'button' => 'Modifier'          
        ]);    
    }

    /**
     * @Route("/admin/formation/categorie/{id}/statut/deleted", name="admin_formation_categorie_statut_deleted")
     */
    public function admin_formation_categorie_statut_deleted(CategorieFormation $category): Response
    {
        $category->setStatut(-1);
        $this->entityManager->save($category);
        $this->addFlash('danger', "Catégorie supprimée");
        return $this->redirectToRoute('admin_formation_categorie_list');    
    }

    /**
     * @Route("/admin/formation/categorie/{id}/reactiver", name="admin_formation_categorie_reactiver")
     */
    public function admin_coach_reactiver(CategorieFormation $category)
    {

        $category->setStatut(1);
        $this->entityManager->save($category);

        $this->addFlash('success', 'Catégorie réactiver');

        return $this->redirectToRoute('admin_formation_categorie_list');
    }

    public function export($data,$action): Response
    {
        
         try{
            $common_file_name = 'liste-categories-formation';
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = ["Nom", "Description","Ordre","Statut",'Progression',"Statut des formations par defaut"];
                $fields = [
                    "nom",
                    "description",
                    "ordreCatFormation",
                    "statutType",
                    "isInProgressionStateString",
                    "statutType",
                    "unlockedByDefaulStatetString",
                ];
                $file = $this->excelService->export($data, $fields, $headers);
    
                $name = $common_file_name."-$date.csv";

                return new BinaryFileResponse($file, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$name\"",
                ]);
            }
            elseif($action == 'excel'){
                $headers = ["Nom", "Description","Ordre","Statut",'Progression',"Statut des formations par defaut"];
                $fields = [
                    "nom",
                    "description",
                    "ordreCatFormation",
                    "statutType",
                    "isInProgressionStateString",
                    "statutType",
                    "unlockedByDefaulStatetString",
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
                    ['name' => "Nom", 'class' => "text-left"],
                    ['name' => "Description"],
                    ['name' => "Ordre", 'class' => "text-center"],
                    ['name' => "Statut"],
                    ['name' => "Progression"],
                    ['name' => "Statut des formations par defaut"],
                ];
                
                $fields = [
                    ['name' => "nom", 'class' => "text-left"],
                    ['name' => "description"],
                    ['name' => "ordreCatFormation", 'class' => "text-center"],
                    ['name' => "statutType"],
                    ['name' => "isInProgressionStateString"],
                    ['name' => "unlockedByDefaulStatetString"],
                ];
                $pdf = $this->pdfExport->generateGenericPDF("Liste catégories (formation)",$data,$headers,$fields);

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
        return $this->redirectToRoute('admin_formation_categorie_list');

    }


}
