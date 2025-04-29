<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function __construct(
        private SessionInterface $session,
    )
    {
        
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('app_dashboard');
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function dashboard()
    {
        if(in_array(User::ROLE_AGENT, $this->getUser()->getRoles())) {
            // return $this->redirectToRoute('agent_home');
            return $this->redirectToRoute('agent_dashboard_secteur', ['id' => $_ENV['SECTEUR_DIGITAL_ID']]);
        }
        elseif(in_array(User::ROLE_COACH, $this->getUser()->getRoles())) {
            return $this->redirectToRoute('coach_dashboard_index');
        }
        elseif(in_array(User::ROLE_ADMINISTRATEUR, $this->getUser()->getRoles())) {
            return $this->redirectToRoute('admin_dashboard');
        }
        else{
            return $this->render('global/index/dashboard.html.twig', [
                'controller_name' => 'IndexController',
            ]);
        }
        
    }

    /**
     * @Route("/launch_messenger", name="app_launch_messenger")
     */
    public function launch_messenger(KernelInterface $kernel)
    {
        $output = null;
        $return = null;
        $projetctDir = $kernel->getProjectDir();
        exec('php '.$projetctDir.'/bin/console messenger:consume async --memory-limit=128M --time-limit=3600', $output, $return);
        return $this->json([
            'output' => $output,
            'return_var' =>$return
        ]);
    }
}
