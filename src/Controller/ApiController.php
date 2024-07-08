<?php


namespace App\Controller;

use App\Entity\User;
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
        try {
            $remunerationService->newOrder($parameters);
            return $this->json('ok');
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }
    }

    #[Route('/fils-parrain-niveau-3/{agentId}', name: 'api_fils_parrain_niveau', methods: ['GET'])]
    public function parrainNiveauAgent(int $agentId, Request $request, RemunerationService $remunerationService): Response
    {
        try {
            return $this->json($remunerationService->getFilsParrainNiveau($agentId));
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }
    }
    #[Route('/', name: 'api_tester', methods: ['GET'])]
    public function testApi(Request $request, RemunerationService $remunerationService): Response
    {
        $parameters = [];
        try {
            $remunerationService->newOrder($parameters);
            return $this->json('ok');
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }
    }
}
