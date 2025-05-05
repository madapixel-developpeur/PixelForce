<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Util\Status;
use App\Services\FileHandler;
use App\Services\SearchService;
use App\Entity\RessourceRubrique;
use App\Util\Search\MyCriteriaParam;
use App\Form\RessourceRubriqueFormType;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RessourceRubriqueFilterType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/coach/ressource-rubriques')]
class CoachRessourceRubriqueController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private RessourceRepository $ressourceRepository,
    private TranslatorInterface $translator
    )
    {
    }

    #[Route('/', name: 'app_coach_ressource_rubrique_list')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 10;
        $criteria = [
            ['prop' => 'name', 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(RessourceRubriqueFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(RessourceRubrique::class, 'r')
        ;

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'r'));
        $query->where($where["where"] . " and r.status = :statusValid and (r.secteur = :secteurId or r.secteur is null) ");
        $where["params"]["statusValid"] = Status::VALID;
        $where["params"]["secteurId"] = $this->getUser()->getUniqueCoachSecteur()?->getId();
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'r.id', 'direction' => 'asc']);

        $result = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/ressource-rubrique/list.html.twig', [
            'result' => $result,
            'form' => $form->createView(),
            'page' => $page
        ]);

    }

    #[Route('/add', name: 'app_coach_ressource_rubrique_add')]
    public function add(Request $request): Response
    {
        $rb = new RessourceRubrique();
        $form = $this->createForm(RessourceRubriqueFormType::class, $rb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $rb->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $rb->setStatus(Status::VALID);
                $this->entityManager->persist($rb);
                $this->entityManager->flush();
                $this->addFlash('success', $this->translator->trans('Rubrique ajouté avec succès'));
                return $this->redirectToRoute('app_coach_ressource_rubrique_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
            
        }

        return $this->render('user_category/coach/ressource-rubrique/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false,
            "rb" => $rb
        ]);
    }

    #[Route('/{id}/edit', name: 'app_coach_ressource_rubrique_edit')]
    public function edit(RessourceRubrique $rb, Request $request): Response
    {
        $form = $this->createForm(RessourceRubriqueFormType::class, $rb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $rb->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $rb->setStatus(Status::VALID);
                $this->entityManager->persist($rb);
                $this->entityManager->flush();
                $this->addFlash('success', $this->translator->trans('Rubrique modifié avec succès'));
                return $this->redirectToRoute('app_coach_ressource_rubrique_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
            
        }

        return $this->render('user_category/coach/ressource-rubrique/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true,
            "rb" => $rb
        ]);
    }


    

    #[Route('/{id}/delete', name: 'app_coach_ressource_rubrique_delete')]
    public function delete(RessourceRubrique $rb): Response
    {
        try {
            $rb->setStatus(Status::INVALID);
            $ressources = $this->ressourceRepository->findBy(['rubrique' => $rb]);
            for($i=0; $i<count($ressources); $i++) {
                $ressources[$i]->setRubrique(null);
                $this->entityManager->persist($ressources[$i]);
            }
            $this->entityManager->persist($rb);
            $this->entityManager->flush();
            $this->addFlash('success', $this->translator->trans('Rubrique supprimé avec succès'));
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('app_coach_ressource_rubrique_list');

    }
}