<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Secteur;
use App\Repository\SecteurRepository;
use App\Repository\AnnouncementRepository;
use App\Repository\SocialMediaInfoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/agent/professionnel')]
class AgentProfessionnelHomeController extends AbstractController
{

    public function __construct(
        private AnnouncementRepository $announcementRepository,
        private SecteurRepository $secteurRepository,
        private SessionInterface $session,
        private SocialMediaInfoRepository $socialMediaInfoRepository
    ) {

    }

    #[Route('/dashboard/secteur/{id}',name : 'agent_pro_dashboard')]
    public function index(Secteur $secteur): Response
    {   
        $user = $this->getUser();
        if($user->getProfesionnalInformationState() == User::INFORMATION_EMPTY){
            return $this->redirectToRoute('professionnel_add_info');     
        }
        $socialMedias = $this->socialMediaInfoRepository->findBy(['secteur' => $secteur]);
        $announcements = $this->announcementRepository->getActiveAnnoncement($secteur,new \DateTime(),['type' => User::ROLE_PROFESSIONNEL]);
        return $this->render('user_category/professionnel/dashboard/dashboard_pro.html.twig',[
            'announcements' => $announcements,
            'secteur' => $secteur,
            'socialMedias' => array_chunk($socialMedias,4)
        ]);
    }

}