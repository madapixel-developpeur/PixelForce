<?php

namespace App\Controller;

use Exception;
use App\Services\PdfExport;
use App\Services\ExcelService;
use App\Services\SearchService;
use App\Form\RemunerationFilterType;
use App\Services\Stat\StatAgentService;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/agent/remuneration")
 */
class RemunerationController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private StatAgentService $statAgentService,
        private ExcelService $excelService,
        private PdfExport $pdfExport
    )
    {
       
    }

 

    /**
     * @Route("/digital/", name="agent_remuneration_list_digital")
     */
    public function indexDigital(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $action = $request->get('action_button');
        $user = (object)$this->getUser();
        $page = $request->query->get('page', 1);
        
        $filter = [];

        $form = $this->createForm(RemunerationFilterType::class, $filter);

        $form->handleRequest($request);
        $filter = $form->getData();
        if(!$filter) $filter = [];
        $filter['ibiId'] = $user->getId();

        if(isset($filter['dateMin']) && $filter['dateMin'])  $filter['dateMin'] = $filter['dateMin']->format('Y-m-d');
        if(isset($filter['dateMax']) && $filter['dateMax'])  $filter['dateMax'] = $filter['dateMax']->format('Y-m-d');
        $filter['page'] = $page;
        $result = $this->statAgentService->getRemunerations($filter);
        if(!empty($action) && $action != 'search_action'){
            return $this->export($result['items'],$action);
        }
        $orderList = $paginator->paginate(
            $result['items'],
            1,
            $result['itemNumberPerPage']
        );
        
        $orderList->setTotalItemCount($result['total']);
        $orderList->setCurrentPageNumber($result['currentPageNumber']);

        return $this->render('user_category/agent/remuneration/remuneration_list.html.twig', [
            'remunerations' => $orderList,
            'form' => $form->createView(),
        ]);

    }


    public function export($data,$action): Response
    {
        
         try{
            $common_file_name = 'liste-remunerations';
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = ["Date", "Description", "Type", "Montant"];
                $fields = [
                    "dateReference",
                    "label",
                    "typeStr",
                    "amount",
                ];
                $file = $this->excelService->export($data, $fields, $headers);
    
                $name = $common_file_name."-$date.csv";

                return new BinaryFileResponse($file, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$name\"",
                ]);
            }
            elseif($action == 'excel'){
                $headers = ["Date", "Description", "Type", "Montant"];
                $fields = [
                    "dateReference",
                    "label",
                    "typeStr",
                    "amount",
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
                $headers = ["Date", "Description", "Type", "Montant"];
                $fields = [
                    "dateReference",
                    "label",
                    "typeStr",
                    "amount",
                ];

                $headers = [
                    ['name' => "Date"],
                    ['name' => "Description"],
                    ['name' => "Type"],
                    ['name' => "Montant"],
                ];

                $fields = [
                    ['name' => "dateReference"],
                    ['name' => "label" ],
                    ['name' => "typeStr"],
                    ['name' => "amount", 'class' => "text-end","symbol" => "€"]
                ];
                $pdf = $this->pdfExport->generateGenericPDF("Historique des rémunérations",$data,$headers,$fields);

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
        return $this->redirectToRoute('agent_remuneration_list_digital');

    }

}