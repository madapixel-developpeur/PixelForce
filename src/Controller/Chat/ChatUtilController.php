<?php


namespace App\Controller\Chat;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/chatutil")
 */
class ChatUtilController extends AbstractController
{

    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $entityManager)
    {
        
    }

    /**
     * @Route("/users/search", name="myapi_search_chat_users", methods={"GET"})
     */
    public function searchChatUsers(Request $request, PaginatorInterface $paginator)
    {
        $result = [];
        $search = $request->get('search', '');
        $page = $request->get('page', 1);
        $nbrPerPage = $request->get('nbrPerPage', 10);

        $query = $this->userRepository->searchChatUsersQueryBuilder($this->getUser(), $search);

        $chatUsers = $paginator->paginate(
            $query,
            $page,
            $nbrPerPage
        );

        
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
        return $this->json([
            'total' => $chatUsers->getTotalItemCount(),
            'data' => $result
        ]);
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

