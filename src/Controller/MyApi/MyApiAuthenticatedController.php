<?php


namespace App\Controller\MyApi;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

/**
 * @Route("/myapi/authenticated")
 */
class MyApiAuthenticatedController extends AbstractController
{

    public function __construct(private UserRepository $userRepository)
    {
        
    }

    /**
     * @Route("/user-details/{userId}", name="myapi_user_details", defaults={"userId": null}, methods={"GET"})
     */
    public function userDetails(Request $request, int|null $userId)
    {
        $user = (object)$this->getUser();
        if($userId !== null) {
            $user = $this->userRepository->find($userId); 
        }
        return $this->json([
            "userId" => $user->getId(),
            "lastname" => $user->getNom(),
            "firstname" => $user->getPrenom(),
            "email" => $user->getEmail(),
            "username" => $user->getUsername(),
            "roles" => $user->getRoles()
        ]);
    }

    /**
     * @Route("/chat-users/search", name="myapi_search_chat_users", methods={"GET"})
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
}