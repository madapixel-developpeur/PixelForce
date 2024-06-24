<?php


namespace App\Controller;


use App\Entity\AgentSecteur;
use App\Repository\LiveChatVideoRepository;
use App\Repository\SecteurRepository;
use App\Services\LiveVideo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AgentZoomController extends AbstractController
{
    /**
     * @var LiveChatVideoRepository
     */
    private $liveChatVideoRepository;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var SecteurRepository
     */
    private $secteurRepository;
    /**
     * @var LiveVideo
     */
    private $liveVideo;

    public function __construct(
        LiveChatVideoRepository $liveChatVideoRepository,
        LiveVideo $liveVideo,
        SessionInterface $session,
        SecteurRepository $secteurRepository
    ) {
        $this->liveChatVideoRepository = $liveChatVideoRepository;
        $this->session = $session;
        $this->secteurRepository = $secteurRepository;
        $this->liveVideo = $liveVideo;
    }

    /**
     * @Route("/agent/zoom/list", name="agent_zoom_list")
     * @IsGranted("ROLE_AGENT")
     */
    public function agent_zoom_list()
    {
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
        $livesForDeletingAuto = $this->liveChatVideoRepository->findBy(['userB' => $this->getUser()]);
        $this->liveVideo->remove($livesForDeletingAuto);
        $lives = $this->liveChatVideoRepository->findBy(['secteur' => $secteur, 'userB' => $this->getUser(), 'isSpeedLive' => null]);
        return $this->render('user_category/agent/zoom/zoom_list.html.twig', [
            'lives' => $lives,
            'liveChatVideoRepo' => $this->liveChatVideoRepository
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/agent/zoom/rejoindre_reunion", name="agent_zoom_rejoindreReunion", options={"expose"=true})
     */
    public function agent_zoom_rejoindreReunion(Request $request)
    {
        $lives = $this->liveChatVideoRepository->findBy(['userB' => $this->getUser(), 'isSpeedLive' => true]);
        $lives_planifier = $this->liveChatVideoRepository->findBy(['userB' => $this->getUser(), 'isSpeedLive' => null, 'code' => $request->query->get('code')]);
        $lives = array_merge($lives, $lives_planifier);
        if (!empty($lives)) {
            return $this->render('live/video/modal_joinLive.html.twig', [
                'lives' => $lives
            ]);
        }

        return $this->json([
            'message' => "Pas de live pour le moment"
        ]);
    }

    /**
     * @Route("/agent/zoom/refuser_reunion/{code}", name="agent_zoom_refuserReunion", options={"expose"=true})
     * @param Request $reques
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function agent_zoom_refuserCall($code)
    {
        $this->liveVideo->refuserCall($code, [
            'id' => base64_encode($this->getUser()->getId()),
            'nom' => $this->getUser()->getNom(),
            'prenom' => $this->getUser()->getPrenom(),
        ]);
        return $this->json(['erreur' => false, 'message' => 'ok']);
    }
}
