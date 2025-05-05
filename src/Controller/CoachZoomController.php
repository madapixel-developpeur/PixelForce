<?php


namespace App\Controller;


use App\Entity\User;
use App\Services\LiveVideo;
use App\Entity\AgentSecteur;
use App\Manager\EntityManager;
use App\Repository\LiveChatVideoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class CoachZoomController extends AbstractController
{

    /**
     * @var LiveVideo
     */
    private $liveVideo;
    /**
     * @var LiveChatVideoRepository
     */
    private $liveChatVideoRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(LiveVideo $liveVideo,
                                LiveChatVideoRepository $liveChatVideoRepository,
                                EntityManager $entityManager,
                                private TranslatorInterface $translator
        )
    {
        $this->liveVideo = $liveVideo;
        $this->liveChatVideoRepository = $liveChatVideoRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/coach/zoom/list", name="coach_zoom_list")
     */
    public function coach_zoom_list(Request $request)
    {
        $secteur = $this->getUser()->getSecteurByCoach();
        $agents = [];

        /** @var AgentSecteur $agentSecteur */
        foreach($secteur->getAgentSecteurs()->toArray() as $agentSecteur) {
            if($agentSecteur->getStatut() && $agentSecteur->getAgent()->getActive() === 1) {
                $agents[] = $agentSecteur->getAgent();
            }

        }

        $livesForDeletingAuto = $this->liveChatVideoRepository->findBy(['userA' => $this->getUser()]);
        $livesForDeletingAuto2 = $this->liveChatVideoRepository->findBy(['userA' => $this->getUser(), 'isInProcess' => true]);
        $this->entityManager->removeMultiple($livesForDeletingAuto2);
        $this->liveVideo->remove($livesForDeletingAuto);
        $livesQuery = $this->liveChatVideoRepository->findByCoach($this->getUser());

        return $this->render('user_category/coach/zoom/zoom_list.html.twig',[
            'livesQuery' => $livesQuery,
            'agents' => $agents,
            'liveChatRepo' => $this->liveChatVideoRepository
        ]);
    }

    /**
     * @Route("/coach/zoom/planifier", name="coach_zoom_planifier")
     * @IsGranted("ROLE_COACH")
     */
    public function coach_zoom_planifier(Request $request, TokenGeneratorInterface $tokenGenerator)
    {
        $users = $request->request->get('users');
        if($users) {
            // si la différence entre la date d'aujourd'hui et la date prévu de la réunion est supérieur à 1journnée, on la suprrime
            $dateNow = new \DateTime();
            if(new \DateTime($request->request->get('dateDebutLive')) < $dateNow &&  ($dateNow->diff(new \DateTime($request->request->get('dateDebutLive'))))->days >= 1) {
                $this->addFlash('danger', 'Veuillez entrer une date dans le futur');
                return $this->redirectToRoute('coach_zoom_list');
            }
            $lives = $this->liveChatVideoRepository->findBy(['code' => $request->request->get('code')]);
            $this->entityManager->removeMultiple($lives);
            /** @var User $userA */
            $userA = $this->getUser();
            $secteur = $userA->getSecteurByCoach();
            $lives = [];
            $token = $tokenGenerator->generateToken();
            foreach($users as $userB) {
                $lives[] = $this->liveVideo->create(
                    $userA,
                    base64_decode($userB),
                    $token,
                    false,
                    new \DateTime($request->request->get('dateDebutLive')),
                    $request->request->get('theme'),
                    $request->request->get('description'),
                    $secteur
                );
            }
            $this->addFlash('success', $this->translator->trans('Planification de la réunion terminée avec succès'));
        } else {
            $this->addFlash('danger', 'Vous devez entrer au moin un agent');
        }

        return $this->redirectToRoute('coach_zoom_list');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/coach/zoom/destruct", name="coach_zoom_destruct", options={"expose"=true})
     */
    public function coach_zoom_destruct(Request $request)
    {
        $lives = $this->liveChatVideoRepository->findBy(['code' => $request->query->get('code')]);
        if(!empty($lives)) {
            $this->entityManager->removeMultiple($lives);
        }

        if($request->isXmlHttpRequest()) {
            return $this->json([
                'message' => 'live supprimé'
            ]);
        }
        $this->addFlash('success', $this->translator->trans('Live supprimé'));
        return $this->redirectToRoute('coach_zoom_list');
    }

    /**
     * @param Request $request
     * @Route("/coach/zoom/live_rapide", name="coach_zoom_liveRapide", options={"expose"=true})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function coach_zoom_liveRapide(Request $request)
    {
        $code = $request->request->get('code');
        $userA = $this->getUser();
        if($users = $request->request->get('users')) {
            foreach($users as $userB) {
                $this->liveVideo->create($userA, base64_decode($userB), $code, true);
                $this->liveVideo->call($userB, $code);
            }
        } else {
            $userB = $request->request->get('userB');
            $this->liveVideo->create($userA, base64_decode($userB), $code, true);
            $this->liveVideo->call($userB, $code);
        }

        return $this->json([
            'error' => false
        ]);

    }

    /**
     *  @Route("/coach/zoom/rappeler_agent/{encodedUser}", name="coach_zoom_rappelerAgent", options={"expose"=true})
     * @param Request $reques
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function coach_zoom_rappelerAgent($encodedUser, Request $request)
    {
        if($request->isMethod('POST')) {
            $this->liveVideo->call($encodedUser);
            return $this->json([
                'message' => 'ok'
            ]);
        }
        return $this->json([
            'message' => 'KO : erreur sur la méthode'
        ]);
    }

    /**
     * @Route("/coach/zoom/lancer_reunion/{codeEncoded}", name="coach_zoom_lancerReunion")
     */
    public function coach_zoom_lancerReunion($codeEncoded, Request $request)
    {
        $code = base64_decode($codeEncoded);
        $lives = $this->liveChatVideoRepository->findBy(['code' => $code]);
        if(empty($lives)) {
            return new Response('', 404);
        }
        foreach($lives as $live) {
            $live->setIsInProcess(true);
            $this->entityManager->persist($live);
            $this->liveVideo->call(base64_encode($live->getUserB()->getId()), $live->getCode());
        }
        $this->entityManager->flush();

        return $this->render('live/video/launch.html.twig', [
            'code' => $code
        ]);

    }
}