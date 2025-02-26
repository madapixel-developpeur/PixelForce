<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Util\Status;
use App\Entity\Ressource;
use App\Entity\Announcement;
use App\Entity\SocialMediaInfo;
use App\Form\AnnouncementFormType;
use App\Services\FileHandler;
use App\Form\RessourceFormType;
use App\Services\SearchService;
use App\Form\RessourceFilterType;
use App\Form\SocialMediaInfoFormType;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/coach/reseaux-sociaux')]
class CoachSocialMediaController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager, 
        private FileHandler $fileHandler)
    {
    }

    
    

    #[Route('/add', name: 'app_social_media_add')]
    public function add(Request $request): Response
    {
        $scMedia = new SocialMediaInfo();
        $form = $this->createForm(SocialMediaInfoFormType::class, $scMedia);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $logo = $form->get('logo')->getData();
                if ($logo) {
                    $filePath = $this->fileHandler->upload($logo, "social-media/");
                    $scMedia->setLogo($filePath);
                }
                $scMedia->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $this->entityManager->persist($scMedia);
                $this->entityManager->flush();

                $this->addFlash('success', sprintf("%s ajouté avec succès.", $scMedia->getName()));
                return $this->redirectToRoute('app_coach_social_media_list');
            } catch (\Exception $ex) {
                // $this->addFlash('danger', $ex->getMessage());
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }

        return $this->render('user_category/coach/social-media/social_media_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_social_media_edit')]
    public function edit(SocialMediaInfo $scMedia, Request $request): Response
    {
        $form = $this->createForm(SocialMediaInfoFormType::class, $scMedia,[
            'isEdit' => true
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $logo = $form->get('logo')->getData();
                if ($logo) {
                    $filePath = $this->fileHandler->upload($logo, "social-media/");
                    $scMedia->setLogo($filePath);
                }
                $scMedia->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $this->entityManager->persist($scMedia);
                $this->entityManager->flush();

                $this->addFlash('success', sprintf("%s modifié avec succès.", $scMedia->getName()));
                return $this->redirectToRoute('app_coach_social_media_list');
            } catch (\Exception $ex) {
                // $this->addFlash('danger', $ex->getMessage());
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }

        return $this->render('user_category/coach/social-media/social_media_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true,
            "scMedia" => $scMedia
        ]);
    }


   
    #[Route('/{id}/delete', name: 'app_social_media_delete', methods: ['POST'])]
    public function delete(SocialMediaInfo $scMedia): Response
    {
        try {
            $name = $scMedia->getName();
            $this->entityManager->remove($scMedia);
            $this->entityManager->flush();
            $this->addFlash('success', "{$name} supprimé avec succès");
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('app_coach_social_media_list');

    }



    #[Route('/', name: 'app_coach_social_media_list')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 20;
    
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('s')
            ->from(SocialMediaInfo::class, 's')
            ->where('s.secteur = :secteur')
            ->setParameter('secteur', $this->getUser()->getUniqueCoachSecteur()?->getId());

        $socialMedias = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/social-media/social_media_list.html.twig', [
            'result' => $socialMedias,
            'page' => $page
        ]);

    }
}