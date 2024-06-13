<?php


namespace App\Controller;


use App\Entity\SearchEntity\UserSearch;
use App\Entity\User;
use App\Form\UserSearchType;
use App\Repository\CoachSecteurRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AgentCoachController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var CoachSecteurRepository
     */
    private $coachSecteurRepository;
    /**
     * @var SecteurRepository
     */
    private $secteurRepository;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PaginatorInterface $paginator, UserRepository $userRepository, CoachSecteurRepository $coachSecteurRepository, SecteurRepository $secteurRepository, SessionInterface $session)
    {

        $this->paginator = $paginator;
        $this->coachSecteurRepository = $coachSecteurRepository;
        $this->secteurRepository = $secteurRepository;
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/agent/coach/list", name="agent_coach_list")
     */
    public function agent_coach_list(Request $request)
    {

        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)->remove('secteur')
                            ->remove('tag')
                            ->remove('dateInscriptionMin')
                            ->remove('active')
                            ->remove('dateInscriptionMax');
        $searchForm->handleRequest($request);

        $searckKeyWord = $request->get('search');
        $query = $this->userRepository->findCoachBySecteur($search, $secteur);
        if(!is_null($searckKeyWord)){
            $query = $this->userRepository->findByKeyWordQuery($searckKeyWord);
        }
        $agents = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );


        return $this->render('user_category/agent/coach/agent_coach_list.html.twig', [
            'coachs' => $agents,
            'searchForm' => $searchForm->createView(),
            'repoCoachSecteur' => $this->coachSecteurRepository,
            'mySector' => $secteur
        ]);
    }

}
