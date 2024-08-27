<?php


namespace App\Controller;

use App\Entity\Contact;
use App\Entity\SearchEntity\UserSearch;
use App\Entity\User;
use App\Form\UserSearchType;
use App\Manager\EntityManager;
use App\Repository\CoachSecteurRepository;
use App\Repository\ContactInformationRepository;
use App\Repository\ContactRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Services\ExcelService;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Knp\Component\Pager\PaginatorInterface;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CoachAgentContactController extends AbstractController
{
    protected $repoUser;
    protected $repoContact;
    protected $repoContactInfo;
    protected $session;
    protected $repoSecteur;
    protected $entityManager;
    protected $repoCoachSecteur;

    public function __construct(UserRepository $repoUser, ContactRepository $repoContact, ContactInformationRepository $repoContactInfo, SessionInterface $session, SecteurRepository $repoSecteur, EntityManager $entityManager, CoachSecteurRepository $repoCoachSecteur)
    {
        $this->repoUser = $repoUser;
        $this->repoContact = $repoContact;
        $this->repoContactInfo = $repoContactInfo;
        $this->session = $session;
        $this->repoSecteur = $repoSecteur;
        $this->entityManager = $entityManager;
        $this->repoCoachSecteur = $repoCoachSecteur;
    }

    /**
     * @Route("/coach/agent/{agent}/contact/liste", name="coach_agent_contact_list")
     */
    public function coach_agent_contact_list(User $agent, Request $request, PaginatorInterface $paginator)
    {
        $coach = $this->getUser();
        $coachSecteur = $this->repoCoachSecteur->findOneBy(['coach' => $coach]);
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)
            ->remove('secteur')
            ->remove('tag')
            ->remove('active')
            ->add('adresse', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse'
                ]
            ])
        ;
        $searchForm->handleRequest($request);

        $contacts = $paginator->paginate(
            $this->repoContact->findContactBySecteur($search, $agent, null),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/coach/contact/list_contacts.html.twig', [
            'contacts' => $contacts,
            'searchForm' => $searchForm->createView(),
            'agent' => $agent
        ]);
    }

    /**
     * @Route("/coach/contact/{id}/view", name="coach_agent_contact_view")
     */
    public function coach_agent_contact_view(Contact $contact, Request $request)
    {

        $formNote = $this->createFormBuilder($contact)
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
        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $note = $request->request->get('form')['note'];
            $contact->setNote($note);
            $this->entityManager->save($contact);

            $this->addFlash('success', 'Note enregistré avec succès');
            return $this->redirectToRoute('coach_agent_contact_view', ['id' => $contact->getId()]);

        }
        $tags = $contact->getTags()->toArray();

        return $this->render('user_category/coach/contact/view_contact.html.twig', [
            'contact' => $contact,
            'formNote' => $formNote->createView(),
            'tags' => $tags
        ]);
    }



    /**
     * @Route("/coach/agent/{agent}/contact/exportExcel", name="coach_agent_contact_export_excel")
     */
    public function coach_agent_contact_export_excel(User $agent, ExcelService $excelService): Response
    {
        $coachSecteur = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()]);
        $secteur = $coachSecteur->getSecteur();

        $contacts = $this->repoContact->findBy(['agent' => $agent, 'secteur' => $secteur]);

        $headers = ["NOM ET PRÉNOMS", "EMAIL", "TÉLÉPHONE", "ADRESSE", "TYPE DU LOGEMENT", "RUE", "NUMÉRO", "CODE POSTAL", "VILLE", "COMPOSITION DU FOYER", "NOMBRE DE PERSONNE", "COMMENTAIRE"];
        $fields = [
            "information.lastname",
            "information.email",
            "information.phone",
            "information.address",
            "information.typeLogement.nom",
            "information.rue",
            "information.numero",
            "information.codePostal",
            "information.ville",
            "information.compositionFoyer",
            "information.nbrPersonne",
            "information.commentaire"
        ];
        $file = $excelService->export($contacts, $fields, $headers);
        $date = (new \DateTime())->format('Y-m-d');
        return $this->file($file, "contact-$date.csv");
    }

    /**
     * @Route("/coach/{agent}/contact/exportPdf", name="coach_agent_contact_export_pdf")
     */
    public function coach_agent_contact_export_pdf(User $agent, DompdfWrapperInterface $wrapper)
    {
        $coachSecteur = $this->repoCoachSecteur->findOneBy(['coach' => $this->getUser()]);
        $secteur = $coachSecteur->getSecteur();
        $contacts = $this->repoContact->findBy(['agent' => $agent, 'secteur' => $secteur]);

        $html = $this->renderView('pdf/contacts.html.twig', [
            'title' => "Liste des contacts",
            'contacts' => $contacts
        ]);
        $date = (new \DateTime())->format('Y-m-d');
        return $wrapper->getStreamResponse($html, "contact-$date.pdf", ['isRemoteEnabled' => true]);
    }

}