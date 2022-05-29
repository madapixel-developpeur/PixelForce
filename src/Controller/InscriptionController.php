<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionAgentType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserManager
     */
    private $userManager;


    public function __construct(EntityManager $entityManager, UserManager $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }


    /**
     * @Route("/inscription/agent/index", name="inscription_agent_index")
     */
    public function inscriptionAgent(Request $request)
    {
        $user = new User();
        $form = $this->createForm(InscriptionAgentType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $this->userManager->setUserPasword($user, $request->request->get('inscription_agent')['password']['first'], '', false);
            $user->setRoles([ User::ROLE_AGENT ]);
            $this->entityManager->save($user);

            $this->addFlash('success','Votre inscription sur Pixelforce a été effectuée avec succès. Veuillez attendre la validation de votre coach pour accéder à la plateforme.');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('security/inscription/form.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
