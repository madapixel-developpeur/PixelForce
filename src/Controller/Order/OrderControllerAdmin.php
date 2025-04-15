<?php

namespace App\Controller\Order;

use DateTime;
use Exception;
use App\Entity\Order;
use App\Services\PdfExport;
use App\Services\ExcelService;
use App\Services\OrderService;
use App\Services\SearchService;
use App\Form\OrderClientFilterType;
use App\Repository\OrderRepository;
use App\Form\OrderSearchTypeDigital;
use App\Util\Search\MyCriteriaParam;
use App\Services\Stat\StatAgentService;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/agent/order")
 */
class OrderControllerAdmin extends AbstractController
{
    private $entityManager;
    private $orderRepository;
    private $orderService;
    private $session; 

    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository, OrderService $orderService, SessionInterface $session, private StatAgentService $statAgentService,
        private ExcelService $excelService,
        private PdfExport $pdfExport
    )
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->session = $session;
    }

    /**
     * @Route("/", name="agent_order_list")
     */
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        if($secteurId == $this->getParameter('secteur_digital_id')) return $this->redirectToRoute('agent_order_list_digital');
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'status'],
            ['prop' => 'dateMin', 'col' => 'orderDate', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'orderDate', 'op' => '<='],
            ['prop' => 'clientName', 'col' => "concat(concat(coalesce(u.prenom, ''), ' '), u.nom)", 'alias' => null, 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(OrderClientFilterType::class, $filter, [
            'method' => 'GET',
            'admin' => true
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->join('o.user', 'u')
            ->join('o.agent', 'a')
            ->join('o.secteur', 's')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'o'));   
        $query->where($where["where"]." and a.id = :agentId and s.id = :secteurId ");
        $where["params"]["agentId"] = $user->getId();
        $where["params"]["secteurId"] = $secteurId;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'o.orderDate', 'direction' => 'desc']);

        $orderList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/agent/order/order_list.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="agent_order_details")
     */
    public function details(Request $request, Order $order): Response
    {
        $error = null;
        return $this->render('user_category/agent/order/order_details.html.twig',[
            'error' => $error,
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative')
        ]);

    }

    /**
     * @Route("/{id}/validate", name="agent_order_validate")
     */
    public function validate(Request $request, int $id): Response
    {
        try{
            $this->orderService->changeStatus($id, Order::VALIDATED);
            $this->addFlash(
                'success',
                'Commande livrée'
            ); 
        } catch(Exception $ex){
            $this->addFlash(
               'error',
               $ex->getMessage()
            );
        } 
        return $this->redirectToRoute('agent_order_details', ['id' => $id]);
    }


    /**
     * @Route("/digital/all", name="agent_order_list_digital")
     */
    public function indexDigital(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $action = $request->get('action_button');
        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        $page = $request->query->get('page', 1);
        
        $filter = [];

        $form = $this->createForm(OrderSearchTypeDigital::class, $filter);

        $form->handleRequest($request);
        $filter = $form->getData();
        if(!$filter) $filter = [];
        $filter['ibiId'] = $user->getId();
        // $filter['ibiId'] = 1;
        if(isset($filter['dateMin']) && $filter['dateMin'])  $filter['dateMin'] = $filter['dateMin']->format('Y-m-d');
        if(isset($filter['dateMax']) && $filter['dateMax'])  $filter['dateMax'] = $filter['dateMax']->format('Y-m-d')." 23:59:59";
        $filter['page'] = $page;
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

        return $this->render('user_category/agent/order/order_list_digital.html.twig', [
            'orderList' => $orderList,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/digital/details/{id}", name="agent_order_details_digital")
     */
    public function detailsDigital(int $id, Request $request): Response
    {
        $error = null;
        return $this->render('user_category/agent/order/order_details_digital.html.twig',[
            'error' => $error,
            'order' => $this->statAgentService->getOrderById($id),
            'filesDirectory' => $this->getParameter('files_directory_relative')
        ]);

    }

    /**
     * @Route("/digital/historique-chiffre-d-affaire", name="agent_ca_list_digital")
     */
    public function getCaHistory(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $action = $request->get('action_button');
        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        $page = $request->query->get('page', 1);
        
        $filter = [];

        $form = $this->createFormBuilder()
        ->add('dateMin', TextType::class, [
            'label' => 'Mois min',
            'attr' => [
                'type' => 'month', 
                'class' => 'form-control month-picker-input',
                'placeholder' => 'YYYY-MM', 
            ],
            'required' => false,
        ])
        ->add('dateMax', TextType::class, [
            'label' => 'Mois max',
            'attr' => [
                'type' => 'month', 
                'class' => 'form-control month-picker-input',
                'placeholder' => 'YYYY-MM',
            ],
            'required' => false,
        ])
        ->getForm();

        
        $form->handleRequest($request);
        $filter = $form->getData();
        if(!$filter) $filter = [];
        $filter['ibiId'] = $user->getId();

        if(isset($filter['dateMin']) && $filter['dateMin'])  $filter['dateMin'] =  (new DateTime($filter['dateMin'] . "-01"))->setTime(0,0,0)->format('Y-m-d H:i:s');
        if(isset($filter['dateMax']) && $filter['dateMax'])  $filter['dateMax'] = (new DateTime($filter['dateMax'] . "-01"))->modify('last day of this month')->setTime(23,59,59)->format('Y-m-d H:i:s');
        $filter['page'] = $page;
        $result = $this->statAgentService->getCaHistory($filter);
        if(!empty($action) && $action != 'search_action'){
            $caHistoryExportParameter = $this->getExportOptionParameter("ca_history");
            return $this->export($result['result'],$action,$caHistoryExportParameter);
        }
        $historiquesCa = $result['result'];
        $totalCa = $result['totalCa'];

       

        return $this->render('user_category/agent/chiffre_affaires/chiffre_affaire_historique.html.twig', [
            'historiquesCa' => $historiquesCa,
            'totalCa' => $totalCa,
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("digital/detail-chiffre-d-affaire/{month}", name="agent_ca_details")
     */
    public function detailsCa(Request $request, PaginatorInterface $paginator,string $month): Response
    {
        try {
            $page = $request->query->get('page', 1);
            $start = (new DateTime($month . "-01"))->setTime(0,0,0)->format('Y-m-d H:i:s');
            $end = (new DateTime($month . "-01"))->modify('last day of this month')->setTime(23,59,59)->format('Y-m-d H:i:s');

            $filter = [
                'dateMin' => $start,
                'dateMax' => $end,
                'ibiId' => $this->getUser()->getId(),
                'page' => $page
            ];

            $result = $this->statAgentService->getOrders($filter);
            $orderList = $paginator->paginate(
                $result['items'],
                1,
                $result['itemNumberPerPage']
            );
            
            $orderList->setTotalItemCount($result['total']);
            $orderList->setCurrentPageNumber($result['currentPageNumber']);

           
        } catch (\Throwable $th) {
            //throw $th;
            return $this->redirectToRoute('agent_ca_list_digital');    
        }
        return $this->render('user_category/agent/chiffre_affaires/chiffre_affaire_historique_detail.html.twig',[
            'orderList' => $orderList,
            'month'  => $month,
            'totalAmount' => $result['totalAmount'],
            'usedTVA' => $result['TVA'] ?? 20
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

    public function getLittlePonnailsOrder(Request $request,PaginatorInterface $paginator){
        $user = (object)$this->getUser();
        $page = $request->query->get('page', 1);
        $result = $this->statAgentService->getOrdersFromLittlePonails($user,$page);
     
        $orderList = $paginator->paginate(
            $result['items'],
            1,
            $result['itemNumberPerPage']
        );
        $orderList->setTotalItemCount($result['total']);
        $orderList->setCurrentPageNumber($result['currentPageNumber']);

        return $this->render('user_category/agent/order/little-ponails/order_list_little_ponails.html.twig', [
            'orderList' => $orderList,
        ]);
    }

     /**
     * @Route("/secteur/list", name="app_common_order_list")
     */
    public function checkOrderSecteur(Request $request,PaginatorInterface $paginator){
        $secteurId = $this->session->get('secteurId');

        if($secteurId == $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            return $this->getLittlePonnailsOrder($request,$paginator);
        }
        throw new Exception('Secteur non prise en charge');
    }

     /**
     * @Route("/little-ponails/order/view/{ref}", name="app_view_order_lpn")
     */
    public function viewOrderLpn(string $ref,Request $request){
        $secteurId = $this->session->get('secteurId');
        if($secteurId != $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
            throw new Exception('Secteur non prise en charge');
        }
        $user = $this->getUser();
        $orderInfo = $this->statAgentService->getOrderDetailFromLittlePonails($user,$ref);
        return $this->render('user_category/agent/order/little-ponails/order_view_little_ponails.html.twig', [
            'orderInfo' => $orderInfo,
        ]);
    }

}