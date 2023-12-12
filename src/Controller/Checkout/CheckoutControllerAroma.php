<?php

namespace App\Controller\Checkout;

use App\Entity\BasketItemAroma;
use App\Entity\Order;
use App\Entity\OrderAddressAroma;
use App\Entity\OrderAroma;
use App\Entity\User;
use App\Form\OrderAddressAromaFormType;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Services\BasketServiceAroma;
use App\Services\ConfigSecteurService;
use App\Services\OrderServiceAroma;
use App\Services\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Route(path: '/client/{token}/checkoutaroma')]
class CheckoutControllerAroma extends AbstractController
{
    private $entityManager;
    private $basketService;
    private $userRepository;
    private $session;
    private $configSecteurService;
    private $orderService;

    
    public function __construct(EntityManagerInterface $entityManager, 
    BasketServiceAroma $basketService, 
    UserRepository $userRepository, 
    SessionInterface $session,
    ConfigSecteurService $configSecteurService,
    OrderServiceAroma $orderService)
    {
        $this->entityManager = $entityManager;
        $this->basketService = $basketService;
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->configSecteurService = $configSecteurService;
        $this->orderService = $orderService;
    }


    #[Route(path: '/address', name: 'client_aroma_checkout_address')]
    public function address(string $token, Request $request, SecteurRepository $secteurRepository): Response
    {
        /** @var User */
        $user = $this->getUser();
        $secteurId = $this->session->get('secteurId');
        $secteur = $secteurRepository->find($secteurId);
        $agent = $this->userRepository->findAgentByToken($token);
        $address = new OrderAddressAroma();
        $address->setLastname($user->getNom());
        $address->setFirstname($user->getPrenom());
        $address->setPhone($user->getTelephone());
        $address->setMail($user->getEmail());
        $form = $this->createForm(OrderAddressAromaFormType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $request->getSession()->set('addressAroma', $address);
                $order = new OrderAroma();
                $order->setUser($user);
                $order->setSecteur($secteur);
                $order->setAgent($agent);
                $order->setAddress($request->getSession()->get('addressAroma'));
                $order = $this->orderService->saveOrder($order);
                return $this->redirectToRoute('client_aroma_checkout_payment', ['token' => $token, 'order' => $order->getId()]);
            } catch(Exception $ex){
                $this->addFlash('danger', $ex->getMessage());
            }
        }
        
        $groupKey = BasketItemAroma::getGroupKeyStatic($agent->getId(), $secteurId);
        $basket = $this->basketService->refreshBasket($groupKey);
        $totalCost = $this->basketService->getTotalCostBasket($basket);
        
        return $this->render('user_category/client/aroma/cart/address.html.twig',[
            'form' => $form->createView(),
            'agent' => $agent,
            'token' => $token,
            'totalCost' => $totalCost,
            'agent' => $agent,
        ]);
        
    }

    
    #[Route(path: '/payment/{order}', name: 'client_aroma_checkout_payment')]
    public function payment(string $token, OrderAroma $order, Request $request, FormFactoryInterface $formFactory, StripeService $stripeService): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        
        $form = $formFactory
            ->createNamedBuilder("payment-form")
            ->add('token', HiddenType::class, [
                'constraints' => [new NotBlank()],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $stripeToken =  $form->get('token')->getData();
                $this->orderService->payOrder($order);
                return $this->redirectToRoute('client_aroma_order_details', ['id' => $order->getId(), 'token' => $token]);
            } catch(Exception $ex){
                $this->addFlash('danger', $ex->getMessage());
            }
        }

        $stripeIntentSecret = $stripeService->intentSecretByPaymentIntentId($order->getChargeId());
        return $this->render('user_category/client/aroma/cart/payment.html.twig',[
            'form' => $form->createView(),
            'agent' => $agent,
            'token' => $token,
            'order' => $order,
            'stripeIntentSecret' => $stripeIntentSecret,
        ]);
        
    }

    
}
