<?php

namespace App\Controller;

use App\Form\RemunerationFilterType;
use App\Services\SearchService;
use App\Services\Stat\StatAgentService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/agent/remuneration")
 */
class RemunerationController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private StatAgentService $statAgentService
    )
    {
       
    }

 

    /**
     * @Route("/digital/", name="agent_remuneration_list_digital")
     */
    public function indexDigital(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {

        $user = (object)$this->getUser();
        $page = $request->query->get('page', 1);
        
        $filter = [];

        $form = $this->createForm(RemunerationFilterType::class, $filter);

        $form->handleRequest($request);
        $filter = $form->getData();
        if(!$filter) $filter = [];
        $filter['ibiId'] = $user->getId();

        if(isset($filter['dateMin']) && $filter['dateMin'])  $filter['dateMin'] = $filter['dateMin']->format('Y-m-d');
        if(isset($filter['dateMax']) && $filter['dateMax'])  $filter['dateMax'] = $filter['dateMax']->format('Y-m-d');
        $filter['page'] = $page;
        $result = $this->statAgentService->getRemunerations($filter);

        $orderList = $paginator->paginate(
            $result['items'],
            1,
            $result['itemNumberPerPage']
        );
        
        $orderList->setTotalItemCount($result['total']);
        $orderList->setCurrentPageNumber($result['currentPageNumber']);

        return $this->render('user_category/agent/remuneration/remuneration_list.html.twig', [
            'remunerations' => $orderList,
            'form' => $form->createView(),
        ]);

    }

}