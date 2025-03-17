<?php


namespace App\Controller;

use Exception;
use App\Services\PdfExport;
use App\Form\RetraitFormType;
use App\Services\ExcelService;
use App\Entity\UserTransaction;
use App\Exception\CustomException;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\UserTransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

/**
 * @Route("/agent/transaction")
 */
class AgentTransactionController extends AbstractController
{
    public function __construct(private SessionInterface $session, private EntityManagerInterface $entityManager, private UserTransactionRepository $userTransactionRepository, private SecteurRepository $secteurRepository,
        private ExcelService $excelService,
        private DompdfWrapperInterface $wrapper,
        private PdfExport $pdfExport
    )
    {
    }
    /**
     * @Route("/retrait", name="agent_transaction_retrait")
     */
    public function retrait(Request $request, PaginatorInterface $paginator)
    {
        $secteurId =  $this->session->get('secteurId');
        $secteur = $this->secteurRepository->find($secteurId);
        $user = $this->getUser();
        $form = $this->createForm(RetraitFormType::class, null, ['rib' => $user->getRib()]);
        $form->handleRequest($request);
        $userSolde = $this->userTransactionRepository->getSolde($user, [$secteurId]);
        $action = $request->get('action_button');
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $countPendintRetrait = $this->userTransactionRepository->getNumberOfPendingRetrait($user, [$secteurId]);
                if ($countPendintRetrait) {
                    throw new \Exception('Une demande de retrait est déjà en cours.');
                }
                $data = $form->getData();
                if ($data->getAmount() > $userSolde) {
                    throw new \Exception('Solde insuffisant');
                }
                $data->setCreatedAt(new \DateTimeImmutable());
                $data->setSecteur($secteur);
                $data->setSortie(true);
                $data->setType(UserTransaction::TYPE_RETRAIT);
                $data->setUser($user);
                $data->setStatus(UserTransaction::STATUS_CREATED);
                $this->entityManager->persist($data);
                $this->entityManager->flush();
                $this->addFlash("success", "Retrait effectué avec succès");
                if (strcasecmp($data->getRib(), $user->getRib()) != 0) {
                    return $this->redirectToRoute('agent_change_rib', ['newRib' => $data->getRib()]);
                }
            } catch (\Exception $e) {
                $this->addFlash("danger", $e->getMessage());
            }
        }
        if(!empty($action) && $action != 'search_action'){
            return $this->export( $this->userTransactionRepository->getHistory($user, [$secteurId], $request->get('search')),$action);
        }
        $history = $paginator->paginate(
            $this->userTransactionRepository->getHistory($user, [$secteurId], $request->get('search')),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('user_category/agent/transaction/retrait.html.twig', [
            'form' => $form->createView(),
            'solde'  => $userSolde,
            'history'  => $history,
        ]);
    }

    public function export($data,$action): Response
    {
        
         try{
            if($action == "csv"){
                $headers = ["Date", "Montant", "RIB", "Statut"];
                $fields = [
                    "createdAtStr",
                    "amount",
                    "rib",
                    "statusRetraitStr"
                ];
                $file = $this->excelService->export($data, $fields, $headers);
        
                $date = (new \DateTime())->format('Y-m-d m:s');
                $name = "transactions-$date.csv";

                return new BinaryFileResponse($file, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$name\"",
                ]);
            }
            elseif($action == 'excel'){
                $headers = ["Date", "Montant", "RIB", "Statut"];
                $fields = [
                    "createdAtStr",
                    "amount",
                    "rib",
                    "statusRetraitStr"
                ];
                $spreadsheet = $this->excelService->exportXlsx($data, $fields, $headers);
        
                $date = (new \DateTime())->format('Y-m-d m:s');
                $name = "transactions-$date.xlsx";

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
                    ['name' =>"Montant"], 
                    ['name' =>"RIB"], 
                    ['name' =>"Statut"]
                ];
                $fields = [
                    ['name' => "createdAtStr", 'class' => "text-center"],
                    ['name' => "amount", 'class' => "text-end","symbol" => "€"],
                    ['name' => "rib",'class' => "text-center"],
                    ['name' => "statusRetraitStr"],
                ];
                $pdf = $this->pdfExport->generateGenericPDF("Historique de transaction",$data,$headers,$fields);

                $fileName = "transactions.pdf";
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
        return $this->redirectToRoute('agent_transaction_retrait');

    }

    /**
     * @Route("/changer-rib/{newRib}", name="agent_change_rib")
     */
    public function changeRibBasedOnLastTransaction(Request $request, $newRib)
    {
        $user = (object)$this->getUser();
        $oldRib = $user->getRib();
        if ($request->getMethod() === Request::METHOD_POST) {
            $decision = $request->request->get('decision');
            if ($decision == "1") {
                $user->setRib($newRib);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->addFlash("success", "RIB changé avec succès");
            }
            return $this->redirectToRoute('agent_transaction_retrait');
        }
        return $this->render('user_category/agent/transaction/change-rib-confirmation.html.twig', [
            'newRib' => $newRib,
            'oldRib'  => $oldRib,
        ]);
    }
}
