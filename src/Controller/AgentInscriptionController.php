<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\AgentSecteur;
use App\Form\InscriptionAgentType;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Manager\UserManager;
use App\Repository\AgentSecteurRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Services\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AgentInscriptionController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserManager
     */
    private $userManager;

    private $stripeManager;

    /** @var SessionInterface $session */
    private $session;

    protected $userRepository;

    public function __construct(EntityManager $entityManager, UserManager $userManager, StripeManager $stripeManager, SessionInterface $session, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->stripeManager = $stripeManager;
        $this->session = $session;
        $this->userRepository = $userRepository;
    }


    /**
     * @Route("/inscription/agent/index", name="agent_inscription")
     */
    public function inscriptionAgent(Request $request, SecteurRepository $secteurRepository)
    {
        $user = new User();
        $form = $this->createForm(InscriptionAgentType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->userManager->setUserPasword($user, $request->request->get('inscription_agent')['password']['first'], '', false);
            $user->setRoles([ User::ROLE_AGENT ]);
            $user->setActive(1);
            $user->setAccountStatus(User::ACCOUNT_STATUS['UNPAID']);
            $this->entityManager->save($user);
            $this->session->set('agentId', $user->getId());
           
            return $this->redirectToRoute('agent_register_payment_intent');
        }

            return $this->render('security/inscription/form.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/inscription/agent/payement/intent", name="agent_register_payment_intent")
     */
    public function agent_register_payment_intent(Request $request, StripeService $stripeService)
    {
        $stripe_publishable_key = $_ENV['STRIPE_PUBLIC_KEY'];
        $priceTrialAccount = USER::ACCOUNT_PRICE['TRIAL'];

        if ($request->query->get('stripe_checkout') && $request->query->get('stripe_checkout') === 'successfully') {
            // Si la transaction est faite, $stripeIntentSecret être vide ou null
            $stripeIntentSecret = '';
        }else{
            $stripeIntentSecret = $stripeService->intentSecret($priceTrialAccount);
        }

        $sessionAgentId =  $this->session->get('agentId');
      
        if (!$sessionAgentId) {
            $this->addFlash(
                'warning',
                'Veuillez reprocéder au paiment car le navigateur a perdu votre session ou vous pouvez aussi vous connecter sur PixelForce pour poursuivre le paiment <br> Mais avant de poursuivre, vueillez verifier votre solde bancaire'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/inscription/agent_register_payment.html.twig', [
            'stripeIntentSecret' => $stripeIntentSecret,
            'stripe_publishable_key' => $stripe_publishable_key,
            'sessionAgentId' => $sessionAgentId,
            'priceTrialAccount' => $priceTrialAccount,
            'agent_accountStatus' => USER::ACCOUNT_STATUS['UNPAID']
        ]);
    }

    /**
     * @Route("/inscription/agent/payement/execute", name="agent_register_payment_execute")
     */
    public function agent_register_payment_execute(Request $request)
    {
        $sessionAgentId =  $this->session->get('agentId');

        if ($request->getMethod() === "POST") {
            $sessionAgentId_Post = intval($_POST['sessionAgentId']);

            if ($sessionAgentId_Post === $sessionAgentId) {
                $user = $this->userRepository->find($sessionAgentId_Post);
                $this->stripeManager->persistPayment($user, $_POST);
            }else{
                return $this->json(
                    [
                        'stripe_checkout' => 'error',
                        'cause' => 'different_agentId'
                    ], 
                    200
                );
            }
        }

        return $this->json(
            ['stripe_checkout' => 'successfully'], 
            200
        );
    }
}
