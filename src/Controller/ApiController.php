<?php


namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\MailerService;
use App\Services\OrderService;
use App\Services\RemunerationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ApiController extends AbstractController
{

    public function __construct(
        private OrderService $orderService
    ) {
        
    }


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

    #[Route('/notif-new-message', name: 'api_notif_new_message', methods: ['POST'])]
    public function notifNewMessage(Request $request, MailerService $mailerService, UserRepository $userRepository): Response
    {
        $parameters = json_decode($request->getContent(), true);
        try {
            $user = $userRepository->find(intval($parameters['recipientUserId']));
            $coach = $userRepository->find(intval($parameters['senderUserId']));
            if (in_array('ROLE_COACH', $coach->getRoles())) {
                $mailerService->sendNotifNewMessage($user, $coach);
            }
            return $this->json(['roles' => $coach->getRoles(), 'email' => $user->getEmail(), 'in_array' => in_array('ROLE_COACH', $coach->getRoles())]);
         } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }
    }

    #[Route('/code-promo/check', name: 'api_check_code_promo', methods: ['GET'])]
    public function checkCodePromoValidity(Request $request): Response
    {
        try {
            $code = $request->query->get('code');
            $ip = $request->query->get('ip');
            $discount = $this->orderService->checkCodePromoValidity($code,$ip,$_ENV['SECTEUR_DIGITAL_ID']);
            return $this->json((float) $discount,200); 
        } catch (\Exception $e) {
            return $this->json($e->getMessage(), 500);
        }
    }

}
