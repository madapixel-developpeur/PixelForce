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
use App\Entity\OrderAddress;

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

    public function __construct(EntityManagerInterface $entityManager, ProduitRepository $produitRepository, FileHandler $fileHandler, BasketService $basketService, OrderService $orderService, UserRepository $userRepository, SessionInterface $session){
        $this->entityManager = $entityManager;
        $this->produitRepository = $produitRepository;
        $this->fileHandler = $fileHandler;
        $this->basketService = $basketService;
        $this->orderService = $orderService;
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

   /**
     * @Route("/", name="client_basket")
     */
    public function index($token, Request $request, PaginatorInterface $paginator): Response
    {

        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $groupKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $error = null;
        $basket = $this->basketService->getBasket($groupKey);
        $totalCost = $this->basketService->getTotalCost($groupKey);
        return $this->render('user_category/client/basket/basket.html.twig', [
            'basket' => $basket,
            'error' => $error,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'totalCost' => $totalCost,
            'agent' => $agent,
            'token' => $token
        ]);
    }

    /**
     * @Route("/address", name="client_order_address")
     */
    public function address($token, Request $request): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $groupKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        if(!$this->basketService->hasItem($groupKey))
            return $this->redirectToRoute('client_basket');

        $error = null;
        //$orderAddress = $this->orderService->getAddressOrDefault();
        $orderAddress = new OrderAddress();

        $form = $this->createForm(OrderAddressType::class, $orderAddress);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $this->orderService->setAddress($orderAddress);
                return $this->redirectToRoute('client_order_payment', ['token' => $token]);
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
     * @Route("/payment", name="client_order_payment")
     */
    public function payment($token, Request $request, FormFactoryInterface $formFactory, SecteurRepository $secteurRepository): Response
    {
        
        if(!$this->orderService->getAddress())
            return $this->redirectToRoute('client_order_address');

        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);

        $error = null;
        $form = $formFactory
            ->createNamedBuilder("payment-form")
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $secteur = $secteurRepository->find($secteurId);
                $stripeToken =  $form->get('token')->getData();
                $order = $this->orderService->saveOrder($stripeToken, $agent, $secteur);
                return $this->redirectToRoute('client_order_details', ['id' => $order->getId(), 'token' => $token]);
            } catch(Exception $ex){
                $error = $ex->getMessage();
            }

        }

        return $this->render('user_category/client/basket/payment.html.twig',[
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
            'form' => $form->createView(),
            'error' => $error,
            'agent' => $agent,
            'token' => $token
        ]);
    }

    /**
     * @Route("/add", name="client_basket_add", methods={"POST"})
     */
    public function add($token, Request $request): JsonResponse
    {
        try{
            $agent = $this->userRepository->findAgentByToken($token);
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
            $agent = $this->userRepository->findAgentByToken($token);
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
            $agent = $this->userRepository->findAgentByToken($token);
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
            $agent = $this->userRepository->findAgentByToken($token);
            $groupKey = BasketItem::getGroupKeyStatic($agent->getId(), $product->getSecteur()->getId());
            $this->basketService->remove($groupKey, $product->getId());
            
            return new JsonResponse(array('basket' => $this->basketService->getBasket($groupKey)));
        } catch(Exception $ex){
            return new JsonResponse(array('message' => $ex->getMessage()), 500);
        }
    }

}
