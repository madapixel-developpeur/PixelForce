<?php


namespace App\Controller\Secteur\Account;

use App\Entity\User;
use App\Entity\Secteur;
use App\Services\AuthService;
use App\Exception\CustomException;
use App\Repository\SecteurRepository;
use App\Form\SignUpLittlePonailsFormType;
use App\Form\SingUpLittlePonailsFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/agent/compte-associe')]
class AgentLinkedAccountController extends AbstractController
{

    public function __construct(
        private SecteurRepository $secteurRepository,
        private SessionInterface $session,
        private AuthService $authService
    ) {

    }

    #[Route('/verifier-compte',name : 'agent_check_platform_secteur_account')]
    public function check(Request $request): Response
    {   
        $user =$this->getUser();
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);

        $form = $this->createFormBuilder()
            ->add('identifier', TextType::class, [
                'label' => 'Email, Username ou ID',
                'required' => true,
            ])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $identifier = $form->get('identifier')->getData();
                if (!$identifier) {
                    throw new CUstomException('Identifiant obligatoire.');
                }
                $this->authService->linkAccount($user,$secteur,$identifier);
                $this->addFlash('success', 'Compte relié avec succès.'); 
                return $this->redirectToRoute('agent_dashboard_secteur', ['id' =>  $secteur_id]);
            } catch (CustomException $e) {
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    $_ENV['CUSTOM_ERROR_MESSAGE']
                );
            }
        }
        return $this->render('user_category/agent/secteur/check_existing_account.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/nouveau-compte',name : 'agent_create_platform_secteur_account')]
    public function createAccount(Request $request): Response
    {   
        $form = $this->createForm(SignUpLittlePonailsFormType::class, []);
        $secteur_id = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->findOneBy(['id' => $secteur_id]);
 
    //     dump($request->files->all());
    // dump($request->request->all());


        $form->handleRequest($request);
        if ($form->isSubmitted()  && $form->isValid()) {
            try {
                $data = $form->getData();
                
                $multipart = [];
                foreach ($data as $key => $value) {
                    $multipart[] = ['name' => $key, 'contents' => $value];
                }

                $files = $this->getFilesDataToSendApi($request,[
                    'supporting_documents',
                    'kbis',
                    'carte_vitale',
                    'siren_vdi',
                ]);
                $multipart = array_merge($multipart,$files);
                dd($multipart);


                $files =  [
                    'supporting_documents' => $supportingDocuments,
                    'kbis' => $kbis,
                    'carte_vitale' => $carteVitale,
                    'siren_vdi' => $sirenVdi,
                ];
                $this->authService->createLittlePonailsAccount($this->getUser(),$secteur,$data,$files);
                $this->addFlash('success', 'Compte relié avec succès.');
                return $this->redirectToRoute('agent_dashboard_secteur', ['id' =>  $secteur_id]);
            } catch (CustomException $e) {
                $this->addFlash(
                    'danger',
                    $e->getMessage()
                );
            } catch (\Exception $e) {
                dd($e);
                $this->addFlash(
                    'danger',
                    $_ENV['CUSTOM_ERROR_MESSAGE']
                );
            }
            
        }

        return $this->render('user_category/agent/secteur/create_account.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    public function getFilesDataToSendApi(Request $request , array $keys){
        $multipart = [];
        foreach ($keys as $key) {
            $documents = $request->files->get($key);
            foreach ($documents as $doc) {
                $multipart[] = [
                    'name' => $key.'[]',
                    'contents' => fopen($doc->getPathname(), 'r'),
                    'filename' => $doc->getClientOriginalName()
                ];
            }
        }
        return $multipart;
    }

}