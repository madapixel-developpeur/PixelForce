<?php

namespace App\Controller\Order;

use App\Controller\BaseControllerClient;
use App\Entity\BasketItem;
use App\Entity\Order;
use App\Entity\OrderSecu;
use App\Entity\OrderSecuAccomp;
use App\Entity\ProduitSecu;
use App\Entity\ProduitSecuAccomp;
use App\Entity\TypeAbonnementSecu;
use App\Entity\TypeInstallationSecu;
use App\Entity\Utilisateur;
use App\Form\MyProduitSecuAccompFilterType;
use App\Form\OrderClientFilterType;
use App\Repository\OrderRepository;
use App\Repository\SecteurRepository;
use App\Repository\TypeAbonnementSecuRepository;
use App\Repository\TypeInstallationSecuRepository;
use App\Repository\UserRepository;
use App\Services\OrderSecuService;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @Route("/client/{token}/makeordersecu")
 */
class MakeOrderSecuControllerClient extends AbstractController
{
    private $entityManager;
    private $userRepository;
    private $session;
    private $orderSecuService;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, SessionInterface $session, OrderSecuService $orderSecuService)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->orderSecuService = $orderSecuService;
    }

    /**
     * @Route("/make/{id}", name="client_make_ordersecu")
     */
    public function index($token, ProduitSecu $produit, Request $request): Response
    {
        
        try{
            $produit->checkValid();
            $order = new OrderSecu();
            $order->setProduit($produit);

            $agent = $this->userRepository->findAgentByToken($token);
            $user = (object) $this->getUser();
            $secteurId = $this->session->get('secteurId');
            $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
            $order->setSessionKey($sessionKey);
            $this->orderSecuService->setOrderSecu($order);
            return $this->redirectToRoute('client_make_ordersecu_abonnement', [
                'token' => $token
            ]);
        } catch(Exception $ex){
            $this->addFlash('danger', $ex->getMessage());
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }

    }
    /**
     * @Route("/order", name="client_make_ordersecu_abonnement")
     */
    public function order($token, Request $request, FormFactoryInterface $formFactory, TypeAbonnementSecuRepository $typeAbonnementSecuRepository): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $user = (object) $this->getUser();
        $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $order = $this->orderSecuService->getOrderSecu($sessionKey);
        if(!$order) {
            $this->addFlash('danger', 'Commander un produit');
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }

        $types = $typeAbonnementSecuRepository->findAll();
        $form = $formFactory
            ->createNamedBuilder("abonnement-form", FormType::class, $order)
            ->add('typeAbonnement', EntityType::class, array(
                'label' => false,
                'label_attr' => array(
                    'class' => 'radio'
                ),
                'required' => true,
                'class' => TypeAbonnementSecu::class,
                'choices' => $types,
                'choice_label' => function(?TypeAbonnementSecu $type) {
                    return $type ? $type->getNom().' '.number_format($type->getPrix(), 2, ',', ' ').' €' : '';
                },
                'expanded' => true,
                'data' => $types[0]
            ))
            ->add('codePromo', TextType::class, [
                "label" => "Code Promo",
                "trim" => true,
                "required" => false
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $this->orderSecuService->calculerPrixProduit($order);
                $this->orderSecuService->setOrderSecu($order);
                return $this->redirectToRoute('client_produitsecuaccomp_list', ['token' => $token]);
            } catch(Exception $ex){
                $error = $ex->getMessage();
                $this->addFlash('danger', $error);
            }

        }
        
        return $this->render('user_category/client/secu/makeorder/makeorder_abonnement.html.twig', [
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'form' => $form->createView(),
            'token' => $token,
            'agent' => $agent,
            'types' => $types
        ]);

    }

    /**
     * @Route("/produitSecuAccomp", name="client_produitsecuaccomp_list")
     */
    public function produitSecuAccomp($token, Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $error = null;
        $page = $request->query->get('page', 1);
        $limit = 6;
        $criteria = [
            ['prop' => 'prixMin', 'op' => '>=', "col" => "prix"],
            ['prop' => 'prixMax', 'op' => '<=', "col" => "prix"],
            ['prop' => 'description', 'op' => 'LIKE'],
            ['prop' => 'nom', 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(MyProduitSecuAccompFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(ProduitSecuAccomp::class, 'p')
            ->join('p.secteur', 's')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'p'));   
        $query->where($where["where"]." and p.statut != 0 and s.id = :secteurId ");
        $where["params"]["secteurId"] = $secteurId;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'p.id', 'direction' => 'asc']);

        $productList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/client/secu/productaccomp/productaccomp_list.html.twig', [
            'productList' => $productList,
            'form' => $form->createView(),
            'error' => $error,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'agent' => $agent,
            'token' => $token
        ]);

    }
    
    /**
     * @Route("/accompAdd/{id}", name="client_make_ordersecu_add_accomp")
     */
    public function addAcomp($token, ProduitSecuAccomp $product, Request $request): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $user = (object) $this->getUser();
        $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $order = $this->orderSecuService->getOrderSecu($sessionKey);
        if(!$order) {
            $this->addFlash('danger', 'Commander un produit');
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }

        try{

            $accomp = new OrderSecuAccomp();
            $accomp->setProduit($product);
            $accomp->setQte(1);
            $order->add($accomp);
            $this->orderSecuService->setOrderSecu($order);
            return $this->redirectToRoute('client_make_ordersecu_accomplist', ['token' => $token]);
        } catch(Exception $ex){
            $this->addFlash('danger', $ex->getMessage());
            return $this->redirectToRoute('client_produitsecuaccomp_list', ['token' => $token]);
        }
    }

    /**
     * @Route("/accompList", name="client_make_ordersecu_accomplist")
     */
    public function accompList($token, Request $request, PaginatorInterface $paginator): Response
    {

        $error = null;
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $user = (object) $this->getUser();
        $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $order = $this->orderSecuService->getOrderSecu($sessionKey);
        if(!$order) {
            $this->addFlash('danger', 'Commander un produit');
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }
        return $this->render('user_category/client/secu/makeorder/makeorder_accomplist.html.twig', [
            'order' => $order,
            'error' => $error,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'agent' => $agent,
            'token' => $token
        ]);
    }
    

    /**
     * @Route("/accompUpdate/{id}", name="client_make_ordersecu_update_accomp")
     */
    public function updateAcomp($token, ProduitSecuAccomp $product, Request $request)
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $user = (object) $this->getUser();
        $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $order = $this->orderSecuService->getOrderSecu($sessionKey);
        if(!$order) {
            $this->addFlash('danger', 'Commander un produit');
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }

        try{

            $accomp = new OrderSecuAccomp();
            $accomp->setProduit($product);
            $accomp->setQte(intval($request->get('qte')));
            $order->update($accomp);
            $this->orderSecuService->setOrderSecu($order);
            
        } catch(Exception $ex){
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('client_make_ordersecu_accomplist', ['token' => $token]);
    }

    /**
     * @Route("/accompRemove/{id}", name="client_make_ordersecu_remove_accomp")
     */
    public function removeAcomp($token, int $id, Request $request): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $user = (object) $this->getUser();
        $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $order = $this->orderSecuService->getOrderSecu($sessionKey);
        if(!$order) {
            $this->addFlash('danger', 'Commander un produit');
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }

        try{
            $order->remove($id);
            $this->orderSecuService->setOrderSecu($order);
            
        } catch(Exception $ex){
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('client_make_ordersecu_accomplist', ['token' => $token]);
    }


    /**
     * @Route("/installation", name="client_make_ordersecu_installation")
     */
    public function installation($token, Request $request, FormFactoryInterface $formFactory, TypeInstallationSecuRepository $typeInstallationSecuRepository): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $user = (object) $this->getUser();
        $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $order = $this->orderSecuService->getOrderSecu($sessionKey);
        if(!$order) {
            $this->addFlash('danger', 'Commander un produit');
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }

        $types = $typeInstallationSecuRepository->findAll();
        $form = $formFactory
            ->createNamedBuilder("installation-form", FormType::class, $order)
            ->add('typeInstallation', EntityType::class, array(
                'label' => false,
                'label_attr' => array(
                    'class' => 'radio'
                ),
                'required' => true,
                'class' => TypeInstallationSecu::class,
                'choices' => $types,
                'choice_label' => function(?TypeInstallationSecu $type) {
                    $text =  $type->getDescription();
                    if($type->getPrix() > 0){
                        $text .= ' ( + '.number_format($type->getPrix(), 2, ',', ' ').' €)';
                    }
                    return $text;
                },
                'expanded' => true,
                'data' => $types[0]
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $this->orderSecuService->setOrderSecu($order);
                return $this->redirectToRoute('client_make_ordersecu_payment', ['token' => $token]);
            } catch(Exception $ex){
                $error = $ex->getMessage();
                $this->addFlash('danger', $error);
            }

        }
        
        return $this->render('user_category/client/secu/makeorder/makeorder_installation.html.twig', [
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'form' => $form->createView(),
            'token' => $token,
            'agent' => $agent,
            'types' => $types
        ]);

    }


    /**
     * @Route("/payment", name="client_make_ordersecu_payment")
     */
    public function payment($token, Request $request, FormFactoryInterface $formFactory, SecteurRepository $secteurRepository): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByToken($token);
        $user = (object) $this->getUser();
        $sessionKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteurId);
        $order = $this->orderSecuService->getOrderSecu($sessionKey);
        if(!$order) {
            $this->addFlash('danger', 'Commander un produit');
            return $this->redirectToRoute('boutique_secteursecu', [
                'id' => $this->session->get('secteurId'),
                'token' => $token
            ]);
        }

        

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
                $secteur = $secteurRepository->find($secteurId);
                $order->setClient($user);
                $order->setAgent($agent);
                $order->setSecteur($secteur);
                $order = $this->orderSecuService->saveOrder($stripeToken, $order);
                $this->orderSecuService->removeOrderSecu($order->getSessionKey());
                return $this->redirectToRoute('client_ordersecu_details', ['id' => $order->getId(), 'token' => $token]);
            } catch(Exception $ex){
                $error = $ex->getMessage();
                $this->addFlash('danger', $error);
            }

        }
        
        return $this->render('user_category/client/secu/makeorder/makeorder_payment.html.twig', [
            'stripe_public_key' => $this->getParameter('stripe_public_key'),
            'order' => $order,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'form' => $form->createView(),
            'token' => $token,
            'agent' => $agent
        ]);

    }
}