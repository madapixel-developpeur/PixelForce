<?php

namespace App\Controller\Order;

use Exception;
use App\Entity\Order;
use App\Exception\CustomException;
use App\Services\PdfExport;
use App\Services\ExcelService;
use App\Services\SearchService;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Form\OrderSearchTypeDigital;
use App\Services\RemunerationService;
use App\Services\Stat\StatAgentService;
use App\Services\Stat\StatCoachService;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/coach/order")
 */
class OrderControllerCoach extends AbstractController
{
    private $entityManager;
    private $orderRepository;
    private $userRepository;
    private $session;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        UserRepository $userRepository, 
        SessionInterface $session,
        private StatAgentService $statAgentService,
        private ExcelService $excelService,
        private PdfExport $pdfExport,
        private TranslatorInterface $translator,
        private StatCoachService $statCoachService
    )
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    /**
     * @Route("/{all}", name="coach_order_history")
     */
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService,int $all = 0): Response
    {
         $action = $request->get('action_button');
        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        $page = $request->query->get('page', 1);
        
        $filter = [];

        $form = $this->createForm(OrderSearchTypeDigital::class, $filter);
        $form->remove('status');

        $form->handleRequest($request);
        $filter = $form->getData();
        if(!$filter) $filter = [];
        if(isset($filter['dateMin']) && $filter['dateMin'])  $filter['dateMin'] = $filter['dateMin']->format('Y-m-d');
        if(isset($filter['dateMax']) && $filter['dateMax'])  $filter['dateMax'] = $filter['dateMax']->format('Y-m-d')." 23:59:59";
        $filter['page'] = $page;
        $filter['needValidation'] = true;
        if($all) {
            $filter['status'] = Order::PAIED;
        }else{
            $filter['pending'] = true;
        }

        $result = $this->statAgentService->getOrders($filter);
        if(!empty($action) && $action != 'search_action'){
            $venteExportParameter = $this->getExportOptionParameter("vente");
            return $this->export($result['items'],$action,$venteExportParameter);
        }
        $orderList = $paginator->paginate(
            $result['items'],
            1,
            $result['itemNumberPerPage']
        );

        $orderList->setTotalItemCount($result['total']);
        $orderList->setCurrentPageNumber($result['currentPageNumber']);
        $statCa = $this->statAgentService->getStatCaAndRemuneration($user,$secteurId);

        return $this->render('user_category/coach/order/order_list_digital.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
            'statCa' => $statCa
        ]);
    }

    public function getExportOptionParameter($type){
        if($type == 'vente'){
            return [
                'file_name' => "liste-commandes",
                'route_name' => "agent_order_list_digital",
                'csv_excel' => [
                    'headers' => ["Date", "Client", "Pack - (service)", "Montant", "Référence", "Statut"],
                    'fields' =>  [
                        "createdAt",
                        "infoClient.firstName",
                        "package.name",
                        "amount",
                        "infoClient.referenceVente",
                        "statusStr"
                    ]
                ],
                'pdf' => [
                    'headers' =>  [
                        ['name' => "Date"],
                        ['name' => "Client"],
                        ['name' => "Pack - (service)"],
                        ['name' => "Montant"],
                        ['name' => "Référence"],
                        ['name' => "Statut"],
                    ],
                    "fields" =>  [
                        ['name' => "createdAt"],
                        ['name' => "infoClient.firstName" ],
                        ['name' => "package.name"],
                        ['name' => "amount", 'class' => "text-end","symbol" => "€","format_number" => true],
                        ['name' => "infoClient.referenceVente"],
                        ['name' => "statusStr"],
                    ],
                    'title' => "Liste des commandes"
                ],
            ];
        }else{
            return [
                'file_name' => "historique-chiffres-affaire",
                'route_name' => "agent_ca_list_digital",
                'csv_excel' => [
                    'headers' => ["Mois", "Nombre de vente", "Chiffre d'affaire"],
                    'fields' =>  [
                        "month",
                        "total_vente",
                        "amount",
                    ]
                ],
                'pdf' => [
                    'headers' =>  [
                        ['name' => "Mois"],
                        ['name' => "Nombre de vente"],
                        ['name' => "Chiffre d'affaire"]
                    ],
                    "fields" =>  [
                        ['name' => "month"],
                        ['name' => "total_vente", 'class' => "text-end", ],
                        ['name' => "amount", 'class' => "text-end", "symbol" => "€" , "format_number" => true],
                    ],
                    'title' => "Historique du chiffre d'affaires"
                ],
            ];

        }
    }


    /**
     * @Route("/change-status/", name="coach_change_order_status", methods={"POST"})
     */
    public function changeStatus(Request $request,RemunerationService $remunerationService): Response
    {
        $status = $request->request->get('status');
        $orderId = $request->request->get('order_id');
        try{
            $data = $this->statCoachService->updateOrderStatus($orderId,$status);
            if($data['orderDigitalData']){
                $remunerationService->newOrder($data['orderDigitalData']);
            }
            $this->addFlash('success', $this->translator->trans('Statut changé avec succès')); 
        } catch(CustomException $ex){
            $this->addFlash('danger',$ex->getMessage());
        } catch (Exception $ex) {
            $this->addFlash(
                'danger',
                $_ENV['CUSTOM_ERROR_MESSAGE']
            );
        }
        return $this->redirectToRoute('coach_order_history');
    }

    //  /**
    //  * @Route("/information-paiement/", name="coach_update_payment_information")
    //  */
    // public function paymentInfomration(Request $request): Response
    // {
       
    // }

    


    public function export($data,$action,$options): Response
    {
         try{
            $common_file_name =  $options['file_name'];
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = $options['csv_excel']['headers'];
                $fields = $options['csv_excel']['fields'];


                $file = $this->excelService->export($data, $fields, $headers);
    
                $name = $common_file_name."-$date.csv";

                return new BinaryFileResponse($file, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$name\"",
                ]);
            }
            elseif($action == 'excel'){
                $headers = $options['csv_excel']['headers'];
                $fields = $options['csv_excel']['fields'];
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

                $headers = $options['pdf']['headers'];
                $fields = $options['pdf']['fields'];
                $pdf = $this->pdfExport->generateGenericPDF($options['pdf']['title'],$data,$headers,$fields);

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
        return $this->redirectToRoute( $options['route_name']);

    }
}