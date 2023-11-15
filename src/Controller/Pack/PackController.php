<?php

namespace App\Controller\Pack;

use App\Entity\OrderPack;
use App\Entity\Pack;
use App\Form\PackPayFormType;
use App\Repository\OrderPackRepository;
use App\Repository\PackRepository;
use App\Services\OrderPackService;
use App\Services\StripeService;
use App\Util\GenericUtil;
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
    public function __construct(private OrderPackRepository $orderPackRepo,private OrderPackService $orderPackService,private PackRepository $packRepository, private StripeService $stripeService)
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
     * @Route("/payment", name="client_pack_payment")
     */
    public function payment(Request $request): Response
    {
        $id = $request->query->get('id');
        $pack = isset($id) ? $this->packRepository->find($id) : null;
        $error = null;
        $form = $this->createForm(PackPayFormType::class);
        $form->handleRequest($request);
        
        $packCost = isset($pack) ? $pack->getCost() : 0;
        $totalAmount = $packCost + OrderPack::SUBSCRIPTION_AMOUNT;

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $stripeToken = $form->get('token')->getData();
                $fullname = $form->get('fullname')->getData();
                $agent = $this->getUser();
                $orderPack = new OrderPack();
                $orderPack->setFullname($fullname);
                $orderPack->setAmount($totalAmount);
                $orderPack->setAgent($agent);
                if($pack!=null) $orderPack->setPack($pack);
                $orderPack->setStatut(OrderPack::CREATED);
                $orderPack = $this->orderPackService->saveOrder($orderPack, $stripeToken);
                $this->addFlash('success', 'Paiement effectué');
                return $this->redirectToRoute('agent_home');
            } catch(Exception $ex){
                $error = $ex->getMessage();
            }
        }
       

        $paymentIntent = $this->stripeService->paymentIntent($totalAmount);
        $paymentIntentId = $paymentIntent->id;
        $stripeIntentSecret = $this->stripeService->intentSecretByPaymentIntentId($paymentIntentId);
        
        return $this->render('user_category/client/pack/pack_payment.html.twig',[
            'pack' => $pack,
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
            'form' => $form->createView(),
            'error' => $error,
            'stripeIntentSecret' => $stripeIntentSecret,
            'totalAmount'=>$totalAmount,
            'subscription'=>[
                'amount'=>OrderPack::SUBSCRIPTION_AMOUNT,
                'interval'=>OrderPack::IntervaltoLocale(OrderPack::SUBSCRIPTION_INTERVAL),
            ]
        ]);

    }
}