<?php


namespace App\Controller;


use App\Entity\Media;
use App\Entity\User;
use App\Repository\FormationAgentRepository;
use App\Repository\SecteurRepository;
use App\Services\DirectoryManagement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{

    /**
     * @var DirectoryManagement
     */
    private $directoryManagement;
    /**
     * @var FormationAgentRepository
     */
    private $formationAgentRepository;
    private $secteurRepository;

    public function __construct(DirectoryManagement $directoryManagement, FormationAgentRepository $formationAgentRepository, SecteurRepository $secteurRepository)
    {
        $this->directoryManagement = $directoryManagement;
        $this->formationAgentRepository = $formationAgentRepository;
        $this->secteurRepository = $secteurRepository;
    }

    /**
     * @Route("/media/download/{id}", name="media_download")
     */
    public function media_formation_download(Media $media, Request $request, SessionInterface $session)
    {
        $formation = $media->getFormation();
        $formationAgentRelation = $this->formationAgentRepository->findOneBy(['formation' => $formation, 'agent' => $this->getUser()]);
        $secteur_id = $session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        // Changement de la condition de téléchargement dû au fichier CoachFormationController->coach_formation_add() ligne 221
//        if($formation->getFormationAgents()->contains($formationAgentRelation)) {
        //if(($secteur && $formation->getSecteur()->getNom() === $secteur->getNom()) || in_array(User::ROLE_ADMINISTRATEUR,$this->getUser()->getRoles())){
            $filePath = $media->getType() === 'document' ?
                $this->directoryManagement->getMediaFolder_formation_document() :
                $this->directoryManagement->getMediaFolder_formation_audio();
            $filePath = $filePath.DIRECTORY_SEPARATOR.$media->getSlug();

            return new BinaryFileResponse($filePath, 200, array(
                'Content-Type' => mime_content_type($filePath),
                'Content-Length' => filesize($filePath),
                'Content-Disposition' => 'attachment; filename=' . $media->getTitre(),
            ));
        //}

        // $this->addFlash('danger', 'Vous n\'avez pas le droit pour télécharger le fichier');

        // $referer = $request->headers->get('referer');

        // return new RedirectResponse($referer);

    }

}