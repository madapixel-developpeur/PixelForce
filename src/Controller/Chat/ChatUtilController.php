<?php


namespace App\Controller\Chat;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/chatutil")
 */
class ChatUtilController extends AbstractController
{

    public function __construct(private UserRepository $userRepository)
    {
        
    }

    /**
     * @Route("/users/search", name="myapi_search_chat_users", methods={"GET"})
     */
    public function searchChatUsers(Request $request)
    {
        $result = [];
        $search = $request->get('search', '');
        $chatUsers = $this->userRepository->searchChatUsers($this->getUser(), $search);
        foreach ($chatUsers as $user) {
            $result[] = [
                "userId" => $user->getId(),
                "lastname" => $user->getNom(),
                "firstname" => $user->getPrenom(),
                "email" => $user->getEmail(),
                "username" => $user->getUsername(),
                "roles" => $user->getRoles()
            ];
        }
        return $this->json($result);
    }

    /**
     * @Route("/token", name="myapi_get_token", methods={"GET"})
     */
    public function getTokenUser(JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        // ...

        return $this->json(['token' => $JWTManager->create($this->getUser())]);
    }

}

