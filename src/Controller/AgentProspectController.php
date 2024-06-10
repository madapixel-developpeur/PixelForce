<?php

namespace App\Controller;

use Exception;
use App\Entity\Prospect;
use App\Form\UserSearchType;
use App\Manager\EntityManager;
use App\Repository\TagRepository;
use App\Services\ProspectService;
use App\Entity\ContactInformation;
use App\Repository\UserRepository;
use App\Entity\ProspectInformation;
use App\Services\User\AgentService;
use App\Form\ProspectInformationType;
use App\Repository\SecteurRepository;
use App\Repository\ProspectRepository;
use App\Entity\SearchEntity\UserSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProspectInformationRepository;
use App\Services\MailerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgentProspectController extends AbstractController
{
    protected $repoUser;
    protected $repoProspect;
    protected $repoSecteur;
    protected $entityManager;


    public function __construct(UserRepository $repoUser, ProspectRepository $repoProspect,SecteurRepository $repoSecteur, EntityManager $entityManager,
        private AgentService $agentService,
        private ProspectService $prospectService,
        private MailerService $mailerService)
    {
        $this->repoUser = $repoUser;
        $this->repoProspect = $repoProspect;
        $this->repoSecteur = $repoSecteur;
        $this->entityManager = $entityManager;
    }



    #[Route('/agent/prospect/liste', name: 'agent_prospect_list')]
    public function agent_prospect_list(Request $request, PaginatorInterface $paginator)
    {
        $agent = $this->getUser();
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)
            ->remove('secteur')
            ->remove('active')
            ->remove('tag')
            ->add('adresse', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('type', ChoiceType::class, [
                "label" => "Type du contact",
                'choices' => array_flip(Prospect::TYPE_ARRAY_FORM),
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ]
            ])
        ;
        $searchForm->handleRequest($request);
        
        $prospects = $paginator->paginate(
            $this->repoProspect->findProspect($search, $agent),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/agent/prospect/list_prospect.html.twig', [
            'prospects' => $prospects,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/agent/client/prospect/add", name="agent_prospect_info_add")
     */
    public function agent_prospect_info_add(Request $request)
    {
        $prospect = new Prospect();
        $form = $this->createForm(ProspectInformationType::class, $prospect);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(isset($request->request->get('prospect_information')['note'])) {
                $prospect->setNote($request->request->get('prospect_information')['note']);
            }
            $prospect->setAgent($this->getUser());
            $prospect->setCreated_at(new \DateTime());
            $this->entityManager->save($prospect);
            $this->addFlash('success', "Ajout du prospect avec succès");
            return $this->redirectToRoute('agent_prospect_list', ['id' => $prospect->getId()]);
        }
        return $this->render('user_category/agent/prospect/add_prospect.html.twig', [
            'form' => $form->createView(),
            'button' => 'Enregistrer',
            'btn_class' =>  'success',
        ]);    
    }

       /**
     * @Route("/agent/prospect/{id}/view", name="agent_prospect_view")
     */
    public function agent_prospect_view(Prospect $prospect, Request $request)
    {

        $formNote = $this->createFormBuilder($prospect)
            ->add('note', CKEditorType::class, [
                'required' => false,
                'label' => false,
                'config' => [
                    'toolbar' => 'note_contact_toolbar'
                ]
            ])
            ->getForm()
        ;

        $formNote->handleRequest($request);
        if($formNote->isSubmitted() && $formNote->isValid()) {
            $note = $request->request->get('form')['note'];
            $prospect->setNote($note);
            $this->entityManager->save($prospect);

            $this->addFlash('success', 'Note enregistré avec succès');
            return $this->redirectToRoute('agent_prospect_view', ['id' => $prospect->getId()]);

        }


        return $this->render('user_category/agent/prospect/view_prospect.html.twig', [
            'prospect' => $prospect,
            'formNote' => $formNote->createView(),
        ]);
    }

     /**
     * @Route("/agent/client/prospect/information/{id}/edit", name="agent_prospect_info_edit")
     */
    public function agent_prospect_info_edit(Request $request, Prospect $prospect)
    {
        $form = $this->createForm(ProspectInformationType::class, $prospect);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(isset($request->request->get('prospect_information')['note'])) {
                $prospect->setNote($request->request->get('prospect_information')['note']);
            }
            $prospect->setAgent($this->getUser());
            $this->entityManager->save($prospect);
            $this->addFlash('success', "Modification du prospect avec succès");
            return $this->redirectToRoute('agent_prospect_view', ['id' => $prospect->getId()]);
        }
        return $this->render('user_category/agent/prospect/add_prospect.html.twig', [
            'form' => $form->createView(),
            'button' => 'Modifier',
            'btn_class' =>  'success',
        ]);     
    }

    #[Route('/agent/prospect/ajouter-à-l-équipe', name: 'prospect_add_to_team')]
    public function agent_add_to_team_list(Request $request)
    {
       try {
            $prospect = $this->repoProspect->findOneBy(['id'=> $request ->get('prospect_id') ]);
            $parrainUsername =$request ->get('parrain');
            $this->agentService->saveProspectAsUSer($this->getUser(),$parrainUsername,$prospect);
            return $this->redirectToRoute('agent_view');
        } catch (\Throwable $th) {
            //throw $th;
            $this->addFlash('danger', $th->getMessage());
        }
        return $this->redirectToRoute('agent_prospect_view', ['id' => $prospect->getId()]);
    }

    /**
     * @Route("/api/add_prospect", name="prospect_api_add", methods={"POST"})
    */
    public function addProspect(ValidatorInterface $validator,Request $request)
    {
        try{
            $parameters = json_decode($request->getContent(), true);
            $requiredFields = ["nom","telephone","email","prenom",'platform'];
            foreach ($requiredFields as $field) {
               if(!isset($parameters[$field])){
                    return new JsonResponse(array('class' => 'alert alert-danger', 'message' => 'Champ '.$field." obligatoire"));
               }
            }
            $collection = new Collection([
                'nom' => [
                    new Assert\Type('string'), 
                    new Assert\NotBlank(), 
                ],
                'prenom' => [
                    new Assert\Type('string'), 
                    new Assert\NotBlank(), 
                ],
                'telephone' => [
                    new Assert\Type('string'), 
                    new Assert\NotBlank(), 
                ],
                'email' => [
                    new Assert\Type('string'), 
                    new Assert\NotBlank(), 
                ],
                'platform' => [
                    new Assert\Type('string'), 
                    new Assert\NotBlank(), 
                ],
            ]);
            $errors = $validator->validate($parameters, $collection);
            if ($errors->count()) {
                $errorsString = (string) $errors;
                return new JsonResponse(array('class' => 'danger', 'message' => $errorsString),500);
            }
            if($this->prospectService->checkExistingInfo($parameters)){
                return new JsonResponse(array('class' => 'success', 'message' => 'Vous êtes déjà inscrit.'));
            }
            $prospect = $this->prospectService->saveProspectViaDataApi($parameters);
            $this->mailerService->sendContactInfo($parameters);
            return new JsonResponse(array('class' => 'success', 'message' => 'Inscription effectuée avec succès'));
        } catch(Exception $ex){
            return new JsonResponse(array('class' => 'danger', 'message' => $ex->getMessage()),500);
        }
    }

}
  