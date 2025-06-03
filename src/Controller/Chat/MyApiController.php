<?php


namespace App\Controller\Chat;

use App\Repository\UserRepository;
use App\Services\User\AgentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/myapi")
 */
class MyApiController extends AbstractController
{

    /**
     * @Route("/login", name="myapi_login", methods={"POST"})
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // Handle authentication logic...
    }

    /**
     * @Route("/user-team/{userId}", name="myapi_team", methods={"GET"})
     */
    public function getTeamWithSelfIncluded(Request $request, int $userId, AgentService $agentService, UserRepository $userRepository)
    {
        $user = $userRepository->find($userId); 
        $team = $agentService->getTeamMembers($user);
        $result = [];
        foreach($team as $member){
            $result[] = $member->getUserDataChat();
        }
        return $this->json($result);
    }
}