<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Form\FichierType;
use App\Repository\RessourceRepository;
use App\Repository\FichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Services\FileHandler;
use Exception;
use Symfony\Component\Form\FormFactoryInterface;

class CoachRessourcesController extends AbstractController
{
    public function __construct(private RessourceRepository $ressourceRepository,private EntityManagerInterface $entityManager, private FormFactoryInterface $formFactoryInterface,private  FileHandler $fileHandler,private FichierRepository $fichierRepository) {

    }
    
    #[Route('/coach/ressources', name: 'app_coach_ressources')]
    public function index(Request $request): Response
    {
        $id_parent = $request->query->getInt('id_parent', 0);
        $id_retour = 0;
        $ressource = new Ressource(); 
        if ($id_parent > 0) {
            $parentRessource = $this->entityManager->getRepository(Ressource::class)->find($id_parent);
            if ($parentRessource) {
                $ressource->setIdParent($parentRessource);
                $id_retour = $parentRessource->getIdParent() ? $parentRessource->getIdParent()->getId() : 0;
            }
        }
        $secteur = $this->getUser()->getSecteurByCoach();
        $ressources = $this->ressourceRepository->findBySecteurAndParent($secteur, $id_parent > 0 ? $id_parent : null);

        $fichiers = $this->fichierRepository->findBySecteurAndParent($secteur, $id_parent > 0 ? $id_parent : null);

        return $this->render('ressource/coach/index.html.twig', [
            'controller_name' => 'CoachRessourcesController',
            'ressources' => $ressources,
            'fichiers' => $fichiers,
            'id' => $id_parent,
            'retour' => $id_retour
        ]);
    }

    #[Route('/coach/add_ressources', name: 'app_coach_add_ressources')]
    public function add_ressource(Request $request): Response
    {
        $isEdit = false;   
        $id_parent = $request->query->getInt('id_parent', 0);
        $ressource = new Ressource(); 
        $form = $this->formFactoryInterface->create(RessourceType::class, $ressource);

        if ($id_parent > 0) {
            $parentRessource = $this->entityManager->getRepository(Ressource::class)->find($id_parent);
            if ($parentRessource) {
                $ressource->setIdParent($parentRessource);
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $ressource->setSecteur($this->getUser()->getSecteurByCoach());

                if ($id_parent > 0) {
                    $parentRessource = $this->entityManager->getRepository(Ressource::class)->find($id_parent);
                    if ($parentRessource) {
                        
                        $parentRessource->setItem($parentRessource->getItem() + 1);
        
                        $this->entityManager->persist($parentRessource);
                    }
                }

                $this->entityManager->persist($ressource);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_coach_ressources', [
                    'id_parent' => $id_parent
                ]);
            } catch (\Exception $ex) {
                // Handle exceptions
                $error = $ex->getMessage();
            }
        }

        return $this->render('ressource/coach/form_dossier.html.twig', [
            'controller_name' => 'CoachRessourcesController',
            'form' => $form->createView(),
            'error' => $error ?? null,
            'isEdit' => $isEdit
        ]);
    }

    /**
     * @Route("/coach/edit_ressources/{id}", name="app_coach_edit_ressources")
     */
    public function edit(Request $request, Ressource $ressource): Response
    {
        $isEdit = true;
        $error = null;
        $id_parent = $request->query->getInt('id_parent', 0);
        $form = $this->createForm(RessourceType::class, $ressource);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $ressource->setSecteur($this->getUser()->getSecteurByCoach());
                $this->entityManager->persist($ressource);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_coach_ressources', [
                    'id_parent' => $id_parent
                ]);
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        }

        return $this->render('ressource/coach/form_dossier.html.twig', [
            'controller_name' => 'CoachRessourcesController',
            'form' => $form -> createView(),
            'error' => $error,
            'isEdit' => $isEdit
        ]);
    }

    /**
     * @Route("/coach/delete_ressources/{id}", name="app_coach_delete_ressources")
     */
    public function delete(Request $request, int $id): Response
    {
        try {
            // Trouver la ressource par ID
            $ressource = $this->entityManager->getRepository(Ressource::class)->find($id);
            $idParent = $request->query->getInt('id_parent', 0);

            if (!$ressource) {
                $this->addFlash('error', 'Ressource non trouvée');
                return $this->redirectToRoute('app_coach_ressources', [
                    'id_parent' => $idParent
                ]);
            }
            
            $parentRessource = $ressource->getIdParent();
            if ($parentRessource) {
                $parentRessource->setItem(max(0, $parentRessource->getItem() - 1));
                $this->entityManager->persist($parentRessource);
            }

            $this->entityManager->remove($ressource);
            $this->entityManager->flush();

            $this->addFlash('success', 'Ressource supprimée');
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $this->addFlash('error', $error);
        }

        return $this->redirectToRoute('app_coach_ressources', [
            'id_parent' => $idParent
        ]);
    }

    /**
     * @Route("/coach/delete_files/{id}", name="app_coach_delete_fichier")
     */
    public function delete_file(Request $request, int $id): Response
    {
        try {
            // Trouver le fichier par ID
            $fichier = $this->entityManager->getRepository(Fichier::class)->find($id);
            $idParent = $request->query->getInt('id_parent', 0);

            if (!$fichier) {
                $this->addFlash('error', 'Ressource non trouvée');
                return $this->redirectToRoute('app_coach_ressources', [
                    'id_parent' => $idParent
                ]);
            }

            $parentRessource = $fichier->getIdParent();
            if ($parentRessource) {
                $parentRessource->setItem(max(0, $parentRessource->getItem() - 1));
                $this->entityManager->persist($parentRessource);
            }

            $this->entityManager->remove($fichier);
            $this->entityManager->flush();

            $this->addFlash('success', 'Fichier supprimé');
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $this->addFlash('error', $error);
        }

        return $this->redirectToRoute('app_coach_ressources', [
            'id_parent' => $idParent
        ]);
    }

    /**
     * @Route("/fichier/new", name="fichier_new")
     */
    public function new(Request $request): Response
    {
        $isEdit = false;
        $id_parent = $request->query->getInt('id_parent', 0);
        $fichier = new Fichier();
        $form = $this->createForm(FichierType::class, $fichier);

        if ($id_parent > 0) {
            $parentRessource = $this->entityManager->getRepository(Ressource::class)->find($id_parent);
            if ($parentRessource) {
                $fichier->setIdParent($parentRessource);
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $doc = $form->get('file')->getData();
                // Appeler la fonction upload
                $filePath = $this->fileHandler->upload($doc, "docs");

                // Extraire uniquement le nom du fichier
                $fileName = basename($filePath);

                $fichier->setFile($fileName); // Enregistrez uniquement le nom du fichier
                $fichier->setSecteur($this->getUser()->getSecteurByCoach());

                if ($id_parent > 0) {
                    $parentRessource = $this->entityManager->getRepository(Ressource::class)->find($id_parent);
                    if ($parentRessource) {
                        $parentRessource->setItem($parentRessource->getItem() + 1);
                        $this->entityManager->persist($parentRessource);
                    }
                }

                $this->entityManager->persist($fichier);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_coach_ressources', [
                    'id_parent' => $id_parent
                ]);
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        }

        return $this->render('ressource/coach/form_fichier.html.twig', [
            'controller_name' => 'CoachRessourcesController',
            'form' => $form->createView(),
            'error' => $error ?? null,
            'isEdit' => $isEdit
        ]);
    }

    /**
     * @Route("/fichier/download/{id}", name="fichier_download")
     */
    public function downloadFile($id): Response
    {
        // Récupération du fichier depuis la base de données
        $fichier = $this->getDoctrine()->getRepository(Fichier::class)->find($id);

        if (!$fichier) {
            throw $this->createNotFoundException('Le fichier n\'existe pas');
        }

        $filePath = $fichier->getFile(); // Obtient le chemin du fichier relatif

        $fullPath = $this->getParameter('kernel.project_dir') . '/public/files/docs/' . $filePath;

        if (!file_exists($fullPath)) {
            throw $this->createNotFoundException('Le fichier n\'existe pas');
        }

        return new BinaryFileResponse($fullPath, 200, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Length' => filesize($fullPath),
            'Content-Disposition' => 'attachment; filename="' . basename($fullPath) . '"',
        ]);
    }
}
