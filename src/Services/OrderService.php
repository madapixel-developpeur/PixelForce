<?php
namespace App\Services;

use App\Entity\BasketItem;
use App\Entity\Mouvement;
use App\Entity\Order;
use App\Entity\OrderAddress;
use App\Entity\OrderProduct;
use App\Entity\Secteur;
use App\Entity\User;
use App\Repository\ConfigSecteurRepository;
use App\Repository\OrderRepository;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderService
{
    private $session;
    private $tokenStorage;
    private $basketService;
    private $entityManager;
    private $produitRepository;
    private $orderRepository;
    private $stripeService;
    private $stockService;
    private $configSecteurService;
    private $mailerService;
    private $fileHandler;
    private $wrapper;

    public function __construct(SessionInterface $session, TokenStorageInterface $tokenStorage, BasketService $basketService, EntityManagerInterface $entityManager, ProduitRepository $produitRepository, OrderRepository $orderRepository, StripeService $stripeService, StockService $stockService, ConfigSecteurService $configSecteurService, MailerService $mailerService, DompdfWrapperInterface $wrapper, FileHandler $fileHandler)
    {
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->basketService = $basketService;
        $this->entityManager = $entityManager;
        $this->produitRepository = $produitRepository;
        $this->orderRepository = $orderRepository;
        $this->stripeService = $stripeService;
        $this->stockService = $stockService;
        $this->configSecteurService = $configSecteurService;
        $this->mailerService = $mailerService;
        $this->fileHandler = $fileHandler;
        $this->wrapper = $wrapper;
    }


    public function getAddress(): ?OrderAddress{
        $address = $this->session->get('orderAddress');
        return $address;
    }

    public function getAddressOrDefault(): OrderAddress {
        $address = $this->getAddress();
        $user = (object)$this->tokenStorage->getToken()->getUser();
        if(!$address) {
            $address = new OrderAddress();
            if($user->getAdresse()){
                $address->setAddress($user->getAdresse());
            }
        }
        return $address;
    }

    public function setAddress(OrderAddress $address){
        $this->session->set('orderAddress', $address);
    }

    public function removeAddress(){
        $this->session->remove('orderAddress');
    }

    public function saveOrder(User $agent, Secteur $secteur): ?Order{
        try{
            $this->entityManager->beginTransaction();
            $groupKey = BasketItem::getGroupKeyStatic($agent->getId(), $secteur->getId());
            $user = $this->tokenStorage->getToken()->getUser();
            $basket = $this->basketService->getBasket($groupKey);
            if(count($basket) == 0) 
                throw new Exception("Le panier est vide");

            $address = $this->getAddress();
            if(!$address) throw new Exception("Adresse invalide");

            $address->setUser($user);
            $this->entityManager->persist($address);

            $order = new Order();
            $order->setTva($this->configSecteurService->findTva());
            $order->setUser($user);
            $order->setAddress($address);
            $order->setOrderDate(new DateTime());
            $order->setStatus(Order::CREATED);
            $order->setAgent($agent);
            $order->setSecteur($secteur);
            $order->setAmount(0);
            $this->entityManager->persist($order);

            $amount = 0;
            foreach($basket as $basketItem){
                $product = $this->produitRepository->find($basketItem->getProduit()->getId());

                $orderProduct = new OrderProduct();
                $orderProduct->setProduct($product);
                $orderProduct->setPrice($basketItem->getProduit()->getPrix());
                $orderProduct->setQty($basketItem->getQuantity());
                $orderProduct->setOrderParent($order);
                $this->entityManager->persist($orderProduct);

                $this->stockService->faireSortie($product, $basketItem->getQuantity(), $order->getOrderDate());
                $amount += $product->getPrix() * $basketItem->getQuantity();
            }
            $order->setAmount($amount); 
            

            $paymentIntent = $this->stripeService->paymentIntent($order->getAmount());
            $order->setChargeId($paymentIntent->id);
            
            $this->entityManager->flush();
            $this->entityManager->commit();
            $this->basketService->removeBasket($groupKey);
            $this->removeAddress();
            
            return $order;
        } catch(\Exception $ex){
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
        }
        finally {
            $this->entityManager->clear();
        }
    }

    public function payOrder(Order $order){
        $paymentIntent = $this->stripeService->getPaymentIntent($order->getChargeId());
        if($paymentIntent->status != "succeeded") throw new Exception("Erreur rencontrée lors du paiement");
        $order->setStatus(Order::PAIED);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        try{
            $this->saveInvoice($order);
            $this->mailerService->sendFactureProduit($order);
        } catch(Exception $ex){}
    }

    public function changeStatus(int $orderId, int $status)
    {
        $order = $this->orderRepository->find($orderId);
        if(!$order)  {
            throw new Exception("La commande n°".$orderId." n'existe pas");
        }
        $order->setStatus($status);
        $this->entityManager->flush();
    }

    public function saveInvoice(Order $order){
        $facturePdf = $this->mailerService->renderTwig('pdf/facture.html.twig', [
            'order' => $order
        ]);
        $binary = $this->wrapper->getPdf($facturePdf, ['isRemoteEnabled' => true, 'isHtml5ParserEnabled'=>true, 'defaultFont'=> 'Arial']);
        $directory = "factures";
        $pj_filepath = $this->fileHandler->saveBinary($binary, "Facture Greenlife Ultimate-Commande n°".$order->getId()." du ".date('Y-m-d-H-i-s').'.pdf', $directory);
        $order->setInvoicePath($pj_filepath);
        $this->entityManager->flush();
    }
}
