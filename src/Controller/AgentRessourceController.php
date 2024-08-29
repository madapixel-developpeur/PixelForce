<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Form\FichierType;
use App\Repository\RessourceRepository;
use App\Repository\FichierRepository;
use App\Repository\SecteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Services\FileHandler;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Exception;
use Symfony\Component\Form\FormFactoryInterface;

class AgentRessourceController extends AbstractController
{
    public function __construct(private RessourceRepository $ressourceRepository,private EntityManagerInterface $entityManager, private FormFactoryInterface $formFactoryInterface,private  FileHandler $fileHandler,private FichierRepository $fichierRepository,private SecteurRepository $secteurRepository,private SessionInterface $session) {

    }
    
    #[Route('/agent/ressources', name: 'app_agent_ressources')]
    public function index(Request $request,SessionInterface $session): Response
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
        $secteur_id = $session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        $ressources = $this->ressourceRepository->findBySecteurAndParent($secteur, $id_parent > 0 ? $id_parent : null);

        $fichiers = $this->fichierRepository->findBySecteurAndParent($secteur, $id_parent > 0 ? $id_parent : null);

        return $this->render('ressource/agent/index.html.twig', [
            'controller_name' => 'AgentRessourcesController',
            'ressources' => $ressources,
            'fichiers' => $fichiers,
            'id' => $id_parent,
            'retour' => $id_retour
        ]);
    }

    /**
     * @Route("/fichier/download/{id}", name="fichier_agent_download")
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
