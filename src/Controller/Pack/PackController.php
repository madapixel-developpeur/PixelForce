<?php

namespace App\Controller\Pack;

use App\Entity\OrderPack;
use App\Entity\Pack;
use App\Entity\SearchEntity\OrderSearch;
use App\Entity\User;
use App\Form\PackPayFormType;
use App\Repository\OrderPackRepository;
use App\Repository\PackRepository;
use App\Repository\UserRepository;
use App\Services\ConfigService;
use App\Services\OrderPackService;
use App\Services\StripeService;
use App\Util\GenericUtil;
use App\Util\ToolKit;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pack")
 */
class PackController extends AbstractController
{
    public function __construct(private UserRepository $userRepo, private ConfigService $configService,private OrderPackRepository $orderPackRepo,private OrderPackService $orderPackService,private PackRepository $packRepository, private StripeService $stripeService)
    {
       
    }

    /**
     * @Route("/", name="client_pack_index")
     */
    public function index(): Response
    {
        $packs = $this->packRepository->findAll();
        return $this->render('user_category/client/pack/pack_index.html.twig', [
            'packs' => $packs
        ]);

    }
     /**
     * @Route("/orders/details/{order_pack_id}", name="agent_pack_orders_details")
     */
    public function agent_pack_orders_details($order_pack_id)
    {
        $error = null;
        $orderPack = $this->orderPackRepo->find($order_pack_id);
        return $this->render('user_category/agent/pack/order_details.html.twig', [
            'order' => $orderPack,
            'error' => null,
            'subscription'=>[
                'amount'=>OrderPack::SUBSCRIPTION_AMOUNT,
                'interval'=>OrderPack::IntervaltoLocale(OrderPack::SUBSCRIPTION_INTERVAL),
            ]
        ]);
    }

    /**
     * @Route("/list", name="app_my_pack_list")
     */
    public function packList(): Response
    {

        $orderPacks = $this->orderPackRepo->findBy(["agent"=>$this->getUser()]);

        return $this->render('user_category/client/pack/pack_list.html.twig', [
            'orderPacks' => $orderPacks
        ]);

    }
    /**
     * @Route("/preview/{pack_id}", name="app_pack_preview")
     */
    public function pack_doc_download($pack_id)
    {
        $pack = $this->packRepository->find($pack_id);
        $filepath = $pack->getDocument();
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative')."/".
            $filepath
        );
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            GenericUtil::getFileName($filepath)
        );
        return $response;
    }
    /**
     * @Route("/invoice/preview/{order_pack_id}", name="app_order_pack_invoice_preview")
     */
    public function order_pack_invoice_download($order_pack_id)
    {
        $orderPack = $this->orderPackRepo->find($order_pack_id);
        $filepath = $orderPack->getInvoicePath();
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative')."/".
            $filepath
        );
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            GenericUtil::getFileName($filepath)
        );
        return $response;
    }
    /**
     * @Route("/order/export/csv/{order_pack_id}", name="app_order_pack_export_to_csv")
     */
    public function app_order_pack_export_to_csv($order_pack_id)
    {
        $orderPack = $this->orderPackRepo->find($order_pack_id);
        if(!is_null($orderPack->getPack()))$this->orderPackService->sendOrderPackToSogec($orderPack);
        $this->addFlash('success', 'Exportation CSV vers Sogec effectué');
        return $this->redirectToRoute('agent_home');
    }
    /**
     * @Route("/payment", name="client_pack_payment")
     */
    public function payment(Request $request): Response
    {
        $id = $request->query->get('id');
        $pack = isset($id) ? $this->packRepository->find($id) : null;
        $error = null;
        $agent = $this->getUser();

        $form = $this->createForm(PackPayFormType::class);
        $form->handleRequest($request);
        
        $packCost = isset($pack) ? $pack->getCost() : 0;
        $subscription_cost = $agent->getHasPaidSubscription() ? 0 : OrderPack::SUBSCRIPTION_AMOUNT;
        $totalAmount = $packCost + $subscription_cost;

        // TVA
        $tva = $this->configService->findTva(); 
        $fraisLivraison = $this->configService->calculerFraisDeLivraison($totalAmount);
        $totalAmountAvecFraisLivraison = $totalAmount + $fraisLivraison;


        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $stripeToken = $form->get('token')->getData();
                $fullname = $form->get('fullname')->getData();
                
                $orderPack = new OrderPack();
                $orderPack->setFullname($fullname);
                // $orderPack->setAmount($totalAmount);
                $orderPack->setAgent($agent);
                

                $orderPack->setMontantSansFraisLivraison($totalAmount);
                $orderPack->setTva( $tva );
                $orderPack->setFraisLivraison($this->configService->calculerFraisDeLivraison($orderPack->getMontantSansFraisLivraison()));
                $orderPack->setAmount(($orderPack->getMontantSansFraisLivraison() + $orderPack->getFraisLivraison())); 

                $orderPack->setParrain($agent->getParrain());
                $orderPack->setStatutDuo(0);

                if($pack!=null) $orderPack->setPack($pack);
                $orderPack->setStatut(OrderPack::CREATED);
                $orderPack = $this->orderPackService->saveOrder($orderPack, $stripeToken);
                if(!is_null($orderPack->getPack()))$this->orderPackService->sendOrderPackProductsToSogec($orderPack->getPack()->getProducts()->toArray());
        

                $this->addFlash('success', 'Paiement effectué');
                return $this->redirectToRoute('agent_home');
            } catch(Exception $ex){
                // throw $ex;
                $error = $ex->getMessage();
            }
        }
       

        $paymentIntent = $this->stripeService->paymentIntent($totalAmountAvecFraisLivraison);
        $paymentIntentId = $paymentIntent->id;
        $stripeIntentSecret = $this->stripeService->intentSecretByPaymentIntentId($paymentIntentId);
        return $this->render('user_category/client/pack/pack_payment.html.twig',[
            'pack' => $pack,
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
            'form' => $form->createView(),
            'error' => $error,
            'stripeIntentSecret' => $stripeIntentSecret,
            'totalAmount'=>$totalAmountAvecFraisLivraison,
            'agent'=>$agent,
            'tva'=>$tva,
            'fraisLivraison'=>$fraisLivraison,
            'subscription'=>[
                'amount'=>OrderPack::SUBSCRIPTION_AMOUNT,
                'interval'=>OrderPack::IntervaltoLocale(OrderPack::SUBSCRIPTION_INTERVAL),
            ]
        ]);


    }
    

}