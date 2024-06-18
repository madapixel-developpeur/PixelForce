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

#[Route('/admin/prospect')]
class AdminProspectController extends AbstractController
{
    protected $repoUser;
    protected $repoProspect;
    protected $repoSecteur;
    protected $entityManager;


    public function __construct(UserRepository $repoUser, ProspectRepository $repoProspect, EntityManager $entityManager,
        private AgentService $agentService,
        private ProspectService $prospectService)
    {
        $this->repoUser = $repoUser;
        $this->repoProspect = $repoProspect;
        $this->entityManager = $entityManager;
    }



    #[Route('/liste', name: 'admin_prospect_list')]
    public function index(Request $request, PaginatorInterface $paginator)
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
                "label" => "Type du prospect",
                'choices' => array_flip(Prospect::TYPE_ARRAY_FORM),
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('platform', ChoiceType::class, [
                "label" => "Plateforme",
                'choices' => array_flip(Prospect::PLATFORM_ARRAY_FORM),
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ]
            ])
        ;
        $searchForm->handleRequest($request);
        

        $prospects = $paginator->paginate(
            $this->repoProspect->findProspect($search),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/prospect/list_prospect.html.twig', [
            'prospects' => $prospects,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/add", name="admin_prospect_add")
     */
    public function add(Request $request)
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
            $this->addFlash('success', "Prospect ajoutée avec succès");
            return $this->redirectToRoute('admin_prospect_list', ['id' => $prospect->getId()]);
        }
        return $this->render('user_category/admin/prospect/form_prospect.html.twig', [
            'form' => $form->createView(),
            'button' => 'Enregistrer',
            'btn_class' =>  'success',
        ]);    
    }

       /**
     * @Route("/view/{id}", name="admin_prospect_view")
     */
    public function view(Prospect $prospect, Request $request)
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
            return $this->redirectToRoute('admin_prospect_view', ['id' => $prospect->getId()]);

        }


        return $this->render('user_category/admin/prospect/view_prospect.html.twig', [
            'prospect' => $prospect,
            'formNote' => $formNote->createView(),
        ]);
    }

     /**
     * @Route("/edit/{id}", name="admin_prospect_edit")
     */
    public function edit(Request $request, Prospect $prospect)
    {
        $form = $this->createForm(ProspectInformationType::class, $prospect);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if(isset($request->request->get('prospect_information')['note'])) {
                $prospect->setNote($request->request->get('prospect_information')['note']);
            }
            $prospect->setAgent($this->getUser());
            $this->entityManager->save($prospect);
            $this->addFlash('success', "Prospect modifié avec succès");
            return $this->redirectToRoute('admin_prospect_view', ['id' => $prospect->getId()]);
        }
        return $this->render('user_category/admin/prospect/form_prospect.html.twig', [
            'form' => $form->createView(),
            'button' => 'Modifier',
            'btn_class' =>  'success',
        ]);     
    }


   
}
  