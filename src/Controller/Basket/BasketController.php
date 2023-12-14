<?php

namespace App\Controller\Basket;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Produit;
use App\Entity\BasketItem;
use App\Entity\Order;
use App\Entity\OrderAddress;
use App\Form\AnonymousSignUpType;
use App\Form\OrderAddressType;
use App\Form\ProduitFormType;
use App\Form\ProduitFilterType;

use App\Repository\ProduitRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\FileHandler;
use Exception;
use App\Services\BasketService;
use App\Services\OrderService;
use App\Services\SecurityService;
use App\Services\StripeService;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Stripe;

/**
 * @Route("/client/{token}/basket")
 */
class BasketController extends AbstractController
{
    private $entityManager;
    private $produitRepository;
    private $fileHandler;
    private $basketService;
    private $orderService;
    private $userRepository;
    private $session;
    private $stripeService;

    public function __construct(private SecurityService $securityService, EntityManagerInterface $entityManager, ProduitRepository $produitRepository, FileHandler $fileHandler, BasketService $basketService, OrderService $orderService, UserRepository $userRepository, SessionInterface $session, StripeService $stripeService){
        $this->entityManager = $entityManager;
        $this->produitRepository = $produitRepository;
        $this->fileHandler = $fileHandler;
        $this->basketService = $basketService;
        $this->orderService = $orderService;
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->stripeService = $stripeService;
    }

   /**
     * @Route("/", name="client_basket")
     */
    public function index($token, Request $request, PaginatorInterface $paginator): Response
    {

        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        $groupKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $error = null;
        $basket = $this->basketService->getBasket($groupKey);
        $totalCost = $this->basketService->getTotalCost($groupKey);
        
        $anonymousForm = $this->createForm(AnonymousSignUpType::class);
        $anonymousForm->handleRequest($request);
        $error = null;
        if ($anonymousForm->isSubmitted() && $anonymousForm->isValid()) {
            try{
                // Register the anonymous user
                $user = $this->securityService->generateCredentialsForAnonymous($request->request->all("anonymous_sign_up"));
                $this->securityService->autoAuthenticate($user);
                return $this->redirectToRoute("client_order_address", ["token"=>$token]);
            }
            catch(\Exception $ex){
                throw $ex;
                $error = $ex->getMessage();
            }
           
        }

        return $this->render('user_category/client/basket/basket.html.twig', [
            'basket' => $basket,
            'error' => $error,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'totalCost' => $totalCost,
            'agent' => $agent,
            'token' => $token,
            'anonymousForm' => $anonymousForm->createView(),

        ]);
    }

    /**
     * @Route("/address", name="client_order_address")
     */
    public function address($token, Request $request, SecteurRepository $secteurRepository): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        $groupKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        if(!$this->basketService->hasItem($groupKey))
            return $this->redirectToRoute('client_basket', ['token' => $token]);

        $user = (object)$this->getUser();
        $error = null;
        //$orderAddress = $this->orderService->getAddressOrDefault();
        $orderAddress = new OrderAddress();
        $orderAddress->setNom($user->getNom());
        $orderAddress->setPrenom($user->getPrenom());
        $orderAddress->setTelephone($user->getTelephone());
        $orderAddress->setEmail($user->getEmail());

        $form = $this->createForm(OrderAddressType::class, $orderAddress);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $secteur = $secteurRepository->find($secteurId);
                $this->orderService->setAddress($orderAddress);
                $order = $this->orderService->saveOrder($agent, $secteur);
                return $this->redirectToRoute('client_order_payment', ['id' => $order->getId(), 'token' => $token]);
            } catch(Exception $ex){
                $error = $ex->getMessage();
            }

        }

        return $this->render('user_category/client/basket/address.html.twig',[
            'form' => $form->createView(),
            'error' => $error,
            'agent' => $agent,
            'token' => $token
        ]);
    }

    /**
     * @Route("/payment/{id}", name="client_order_payment")
     */
    public function payment($token, Order $order, Request $request, FormFactoryInterface $formFactory, SecteurRepository $secteurRepository): Response
    {
        
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);

        $error = null;
        $form = $formFactory
            ->createNamedBuilder("payment-form")
            ->add('token', HiddenType::class, [
                //'constraints' => [new NotBlank()],
            ])
            ->getForm();

        $form->handleRequest($request);
        var_dump($form->isSubmitted() && $form->isValid());
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $paymentIntentId =  $form->get('token')->getData();
                $this->orderService->payOrder($order);          
                $this->addFlash('success', 'Votre commande a été efféctuée avec succès.');
                return $this->redirectToRoute('client_order_details', ['id' => $order->getId(), 'token' => $token]);
            } catch(Exception $ex){
                $error = $ex->getMessage();
                $this->addFlash('danger', $error);
            }

        }

        $stripeIntentSecret = $this->stripeService->intentSecretByPaymentIntentId($order->getChargeId());
        return $this->render('user_category/client/basket/payment.html.twig',[
            'stripeIntentSecret' => $stripeIntentSecret,
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
            'form' => $form->createView(),
            'error' => $error,
            'agent' => $agent,
            'token' => $token,
            'order' => $order
        ]);
    }

    /**
     * @Route("/add", name="client_basket_add", methods={"POST"})
     */
    public function add($token, Request $request): JsonResponse
    {
        try{
            $agent = $this->userRepository->findAgentByUsername($token);
            $data = json_decode( $request->getContent(), true);
            $productId = $data['productId'];
            $quantity = $data['quantity'];

            $product = $this->produitRepository->find($productId);

            
            $basketItem = new BasketItem($product, $quantity);
            $basketItem->setSecteurId($product->getSecteur()->getId());
            $basketItem->setAgentId($agent->getId());
            
            $this->basketService->add($basketItem);
            
            return new JsonResponse(array('basket' => $this->basketService->getBasket($basketItem->getGroupKey())));
        } catch(Exception $ex){
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }

    /**
     * @Route("/add/{id}", name="client_basket_add_normal")
     */
    public function addNormal($token, Produit $product, Request $request): Response
    {
        try{
            $agent = $this->userRepository->findAgentByUsername($token);
            $quantity = 1;
            $basketItem = new BasketItem($product, $quantity);
            $basketItem->setAgentId($agent->getId());
            $basketItem->setSecteurId($product->getSecteur()->getId());
            $this->basketService->add($basketItem);
            
            return $this->redirectToRoute('client_basket', ['token' => $token]);
        } catch(Exception $ex){
            $this->addFlash('danger', $ex->getMessage());
            return $this->redirectToRoute('boutique_secteur', ['token' => $token, 'id' => $product->getSecteur()->getId()]);
        }
    }

    /**
     * @Route("/update", name="client_basket_update", methods={"PUT"})
     */
    public function update($token, Request $request): JsonResponse
    {
        try{
            $agent = $this->userRepository->findAgentByUsername($token);
            $data = json_decode( $request->getContent(), true);
            $productId = $data['productId'];
            $quantity = $data['quantity'];

            $product = $this->produitRepository->find($productId);
            $basketItem = new BasketItem($product, $quantity);
            $basketItem->setAgentId($agent->getId());
            $basketItem->setSecteurId($product->getSecteur()->getId());
            
            $this->basketService->update($productId, $basketItem);
            
            return new JsonResponse(array('basket' => $this->basketService->getBasket($basketItem->getGroupKey())));
        } catch(Exception $ex){
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }

    /**
     * @Route("/remove/{id}", name="client_basket_remove", methods={"DELETE"})
     */
    public function remove($token, Produit $product): JsonResponse
    {
        try{
            $agent = $this->userRepository->findAgentByUsername($token);
            $groupKey = BasketItem::getGroupKeyStatic($agent->getId(), $product->getSecteur()->getId());
            $this->basketService->remove($groupKey, $product->getId());
            
            return new JsonResponse(array('basket' => $this->basketService->getBasket($groupKey)));
        } catch(Exception $ex){
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }

}
