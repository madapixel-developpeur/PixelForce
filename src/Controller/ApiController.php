<?php


namespace App\Controller;

use App\Services\RemunerationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{

    #[Route('/new-digital-order', name: 'api_new_digital_order', methods: ['POST'])]
    public function newDigitalOrder(Request $request, RemunerationService $remunerationService): Response
    {
        $parameters = json_decode($request->getContent(), true);
        try{
            $remunerationService->newOrder($parameters);
            return $this->json('ok');
        } catch(\Exception $e){
            return $this->json($e->getMessage(), 500);
        }
        
    }
}
