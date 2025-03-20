<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Entity\FormationTheme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Services\FileHandler;
use App\Util\Status;
use App\Form\FormationThemeFormType;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\FormationThemeFilterType;
use App\Repository\CategorieFormationRepository;
use App\Repository\FormationRepository;

#[Route('/coach/formation-themes')]
class CoachFormationThemeController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private CategorieFormationRepository $categorieFormationRepository, private FormationRepository $formationRepository)
    {
    }
    #[Route('/add', name: 'app_coach_formation_theme_add')]
    public function add(Request $request): Response
    {
        $categorieFormationId = $request->get('categorieFormationId', null);
        $theme = new FormationTheme();
        if($categorieFormationId) {
            $theme->setCategorieFormation($this->categorieFormationRepository->find(intval($categorieFormationId)));
        }
        $form = $this->createForm(FormationThemeFormType::class, $theme);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $theme->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $theme->setStatut(Status::VALID);
                $this->entityManager->persist($theme);
                $this->entityManager->flush();
                $this->addFlash('success', 'Thème ajouté avec succès');
                return $this->redirectToRoute('coach_formation_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
            
        }

        return $this->render('user_category/coach/formation-theme/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false,
            "theme" => $theme
        ]);
    }

    #[Route('/{id}/edit', name: 'app_coach_formation_theme_edit')]
    public function edit(FormationTheme $theme, Request $request): Response
    {
        $form = $this->createForm(FormationThemeFormType::class, $theme);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                $theme->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $theme->setStatut(Status::VALID);
                $this->entityManager->persist($theme);
                $this->entityManager->flush();
                $this->addFlash('success', 'Thème modifié avec succès');
                return $this->redirectToRoute('coach_formation_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
            
        }

        return $this->render('user_category/coach/formation-theme/form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true,
            "theme" => $theme
        ]);
    }


    

    #[Route('/{id}/delete', name: 'app_coach_formation_theme_delete', methods: ['POST'])]
    public function delete(FormationTheme $theme): Response
    {
        try {
            $theme->setStatut(Status::INVALID);
            $formations = $this->formationRepository->findBy(['theme' => $theme]);
            for($i=0; $i<count($formations); $i++) {
                $formations[$i]->setTheme(null);
                $this->entityManager->persist($formations[$i]);
            }
            $this->entityManager->persist($theme);
            $this->entityManager->flush();
            $this->addFlash('success', 'Thème supprimé avec succès');
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('coach_formation_list');

    }
}