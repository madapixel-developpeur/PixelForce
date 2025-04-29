<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Entity\Ressource;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AgentSecteurRepository;
use App\Services\User\AgentService;

#[Route('/agent/view-share')]
class AgentViewShareController extends AbstractController
{

    #[Route('', name: 'app_agent_view_share')]
    public function index(Request $request, AgentSecteurRepository $agentSecteurRepository, SessionInterface $session, AgentService $agentService): Response
    {
        $user = $this->getUser();
        $shareKey = $request->get('shareKey', '');
        $parts = explode("-", $shareKey);
        if($parts[0] == 'secteur'){
            $secteurId = intval($parts[1]);

            $agentSecteur = $agentSecteurRepository->findOneBy(['agent' => $user, 'secteur' => $secteurId, 'statut' => true]);
            if($agentSecteur) {
                $agentService->setSesssionEnabledContent($user);
                $session->set('secteurId', $secteurId);
                $session->set('typeSecteurId', $agentSecteur->getSecteur()->getType()->getId());
                if($parts[2] == 'formation') {
                    return $this->redirectToRoute('agent_formation_fiche', ['id' => intval($parts[3])]);
                } else if($parts[2] == 'quiz') {
                    return $this->redirectToRoute('agent_quiz_begin', ['id' => intval($parts[3])]);

                } else if($parts[2] == 'ressource') {
                    $type = Ressource::TYPE_REVENDEUR;
                    if(!$this->isGranted(User::ROLE_REVENDEUR)){
                        $type = Ressource::TYPE_PROFESSIONNEL;
                    }
                    return $this->redirectToRoute('agent_ressource_details', ['id' => intval($parts[3]), 'type' => $type]);
                } 
            }
        }

        return $this->redirectToRoute('agent_home');        
    }
}