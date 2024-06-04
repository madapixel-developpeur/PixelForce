<?php

namespace App\Controller;

use App\Entity\Prospect;
use App\Form\UserSearchType;
use App\Manager\EntityManager;
use App\Repository\TagRepository;
use App\Entity\ContactInformation;
use App\Repository\UserRepository;
use App\Entity\ProspectInformation;
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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgentProspectController extends AbstractController
{
    protected $repoUser;
    protected $repoProspect;
    protected $repoSecteur;
    protected $entityManager;


    public function __construct(UserRepository $repoUser, ProspectRepository $repoProspect,SecteurRepository $repoSecteur, EntityManager $entityManager)
    {
        $this->repoUser = $repoUser;
        $this->repoProspect = $repoProspect;
        $this->repoSecteur = $repoSecteur;
        $this->entityManager = $entityManager;
    }



    #[Route('/agent/prospect/liste', name: 'agent_prospect_list')]
    public function agent_contact_list(Request $request, PaginatorInterface $paginator)
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
    public function agent_contact_info_add(Request $request)
    {
        // dd('here');
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

}
