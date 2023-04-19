<?php

namespace App\Controller\Order;

use App\Entity\Order;
use App\Entity\OrderAroma;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/common/orderaroma")
 */
class OrderControllerCommon extends AbstractController
{
    

    /**
     * @Route("/downloadFacture/{id}", name="common_orderaroma_download_facture")
     */
    public function downloadFacture(OrderAroma $order): Response
    {
        
        $filename = $order->getInvoicePath();
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative')."/".$filename
        );
        $response->headers->set('Content-Type', 'appication/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
        return $response;
    }

    /**
     * @Route("/downloadBL/{id}", name="common_orderaroma_download_bl")
     */
    public function downloadBL(OrderAroma $order): Response
    {
        
        $filename = $order->getDeliveryOrderPath();
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative')."/".$filename
        );
        $response->headers->set('Content-Type', 'appication/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
        return $response;
    }
}