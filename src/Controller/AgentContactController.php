<?php


namespace App\Controller;

use App\Entity\User;
use App\Entity\Contact;
use App\Form\UserSearchType;
use App\Manager\EntityManager;
use App\Services\ExcelService;
use App\Manager\ContactManager;
use App\Services\ContactService;
use App\Repository\TagRepository;
use App\Entity\ContactInformation;
use App\Repository\UserRepository;
use App\Form\ContactInformationType;
use App\Repository\ContactRepository;
use App\Repository\SecteurRepository;
use App\Entity\SearchEntity\UserSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactInformationRepository;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgentContactController extends AbstractController
{
    protected $repoUser;
    protected $repoContact;
    protected $repoContactInfo;
    protected $session;
    protected $repoSecteur;
    protected $entityManager;
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(TagRepository $tagRepository, UserRepository $repoUser, ContactRepository $repoContact, ContactInformationRepository $repoContactInfo, SessionInterface $session, SecteurRepository $repoSecteur, EntityManager $entityManager)
    {
        $this->repoUser = $repoUser;
        $this->repoContact = $repoContact;
        $this->repoContactInfo = $repoContactInfo;
        $this->session = $session;
        $this->repoSecteur = $repoSecteur;
        $this->entityManager = $entityManager;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @Route("/agent/contact/liste", name="agent_contact_list", options={"expose"=true})
     */
    public function agent_contact_list(Request $request, PaginatorInterface $paginator)
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->getUser();
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)
            ->remove('secteur')
            ->remove('active')
            ->add('adresse', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('type', ChoiceType::class, [
                "label" => "Type du contact",
                'choices' => array_flip(ContactInformation::TYPE_ARRAY_FORM),
                'required' => false,
                'attr' => [
                    'class' => "form-control"
                ]
            ]);
        $searchForm->handleRequest($request);

        $contacts = $paginator->paginate(
            $this->repoContact->findContactBySecteur($search, $agent, $secteurId, $request->get('search')),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/agent/contact/list_contacts.html.twig', [
            'contacts' => $contacts,
            'searchForm' => $searchForm->createView()
        ]);
    }

    /**
     * @Route("/agent/contact/{id}/view", name="agent_contact_view")
     */
    public function agent_contact_view(Contact $contact, Request $request)
    {

        $formNote = $this->createFormBuilder($contact)
            ->add('note', CKEditorType::class, [
                'required' => false,
                'label' => false,
                'config' => [
                    'toolbar' => 'note_contact_toolbar'
                ]
            ])
            ->getForm();

        $formNote->handleRequest($request);
        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $note = $request->request->get('form')['note'];
            $contact->setNote($note);
            $this->entityManager->save($contact);

            $this->addFlash('success', 'Note enregistré avec succès');
            return $this->redirectToRoute('agent_contact_view', ['id' => $contact->getId()]);
        }

        $tags = $contact->getTags() ? $contact->getTags() : [];

        return $this->render('user_category/agent/contact/view_contact.html.twig', [
            'contact' => $contact,
            'formNote' => $formNote->createView(),
            'tags' => $tags
        ]);
    }


    /**
     * @Route("/agent/contact/exportExcel", name="agent_contact_export_excel")
     */
    public function agent_contact_export_excel(Request $request, ExcelService $excelService): Response
    {
        $secteurId = $this->session->get('secteurId');
        $secteur = $this->repoSecteur->find($secteurId);
        $contacts = $this->repoContact->findBy(['agent' => $this->getUser(), 'secteur' => $secteur]);

        $headers = ["NOM ET PRÉNOMS", "EMAIL", "TÉLÉPHONE", "ADRESSE", "TYPE DU LOGEMENT", "RUE", "NUMÉRO", "CODE POSTAL", "VILLE", "COMPOSITION DU FOYER", "NOMBRE DE PERSONNE", "COMMENTAIRE"];
        $fields = [
            "information.lastname", "information.email", "information.phone", "information.address",
            "information.typeLogement.nom", "information.rue", "information.numero", "information.codePostal",
            "information.ville", "information.compositionFoyer", "information.nbrPersonne", "information.commentaire"
        ];
        $file = $excelService->export($contacts, $fields, $headers);

        $date = (new \DateTime())->format('Y-m-d m:s');
        return $this->file($file, "contact-$date.csv");
    }

    /**
     * @Route("/agent/contact/exportPdf", name="agent_contact_export_pdf")
     */
    public function agent_contact_export_pdf(Request $request, DompdfWrapperInterface $wrapper)
    {
        $secteurId = $this->session->get('secteurId');
        $secteur = $this->repoSecteur->find($secteurId);
        $contacts = $this->repoContact->findBy(['agent' => $this->getUser(), 'secteur' => $secteur]);

        $html = $this->renderView('pdf/contacts.html.twig', [
            'title' => "Liste des contacts",
            'contacts' => $contacts
        ]);
        $date = (new \DateTime())->format('Y-m-d m:s');
        return $wrapper->getStreamResponse($html, "contact-$date.pdf", ['isRemoteEnabled' => true]);
    }

    /**
     * @Route("/agent/mobile/contacts/exportPdf", name="agent_mobile_contact_export_pdf", options={"expose"=true})
     */
    public function agent_mobile_contact_export_pdf(DompdfWrapperInterface $wrapper, ContactService $contactService, ExcelService $excelService)
    {
        $agent = $this->getUser();
        $secteurId = $this->session->get('secteurId');
        $secteur = $this->repoSecteur->find($secteurId);

        $contacts = [];
        if (isset($_POST['contacts'])) {
            $contactsApi = $_POST['contacts'];

            foreach ($contactsApi as $contactApi) {
                $contactEntity = new Contact();
                // /** @var ContactInformation $information */
                $information = $contactEntity->getInformation();
                $information = new ContactInformation();
                $contactEntity = $contactService->contactApiToContactEntity($contactApi, $contactEntity, $information);
                $contactEntity->setAgent($agent);
                $contactEntity->setSecteur($secteur);
                $contacts[] = $contactEntity;
            }
        } else {
            return $this->json(['contacts' => 'empty']);
        }

        $fields = [
            "information.lastname", "information.email", "information.phone", "information.address",
            "information.typeLogement.nom", "information.rue", "information.numero", "information.codePostal",
            "information.ville", "information.compositionFoyer", "information.nbrPersonne"
        ];

        $rows = $excelService->getrowsInTable($contacts, $fields);

        return $this->json([
            'contacts' => 'successfully',
            'datas' => $rows

        ]);
    }

    /**
     * @Route("/agent/mobile/contacts/exportExcel", name="agent_mobile_contact_export_excel", options={"expose"=true})
     */
    public function agent_mobile_contact_export_excel(ExcelService $excelService, ContactService $contactService)
    {
        $agent = $this->getUser();
        $secteurId = $this->session->get('secteurId');
        $secteur = $this->repoSecteur->find($secteurId);

        $contacts = [];
        if (isset($_POST['contacts'])) {
            if ($_POST['contacts']) {
                $contactsApi = $_POST['contacts'];

                foreach ($contactsApi as $contactApi) {
                    $contactEntity = new Contact();
                    // /** @var ContactInformation $information */
                    $information = $contactEntity->getInformation();
                    $information = new ContactInformation();
                    $contactEntity = $contactService->contactApiToContactEntity($contactApi, $contactEntity, $information);
                    $contactEntity->setAgent($agent);
                    $contactEntity->setSecteur($secteur);
                    $contacts[] = $contactEntity;
                }
            } else {
                return $this->redirectToRoute('agent_contact_list');
            }
        } else {
            return $this->json(['contacts' => 'empty']);
        }

        $fields = [
            "information.lastname", "information.email", "information.phone", "information.address",
            "information.typeLogement.nom", "information.rue", "information.numero", "information.codePostal",
            "information.ville", "information.compositionFoyer", "information.nbrPersonne"
        ];

        $rows = $excelService->getrowsInTable($contacts, $fields);

        return $this->json([
            'contacts' => 'successfully',
            'datas' => $rows

        ]);
    }

    /**
     * @Route("agent/contac/import/export/mobile", name="agent_contact_import_export_mobile")
     */
    public function agent_contact_import_export_mobile(): Response
    {
        return $this->render('user_category/agent/contact/list_contacts_mobile.html.twig', [
            'google_client_id' => $_ENV['GOOGLE_CLIENT_ID'],
            'google_api_key' => $_ENV['GOOGLE_API_KEY'],

        ]);
    }


    /**
     * @Route("/agent/contact/mobile/import", name="agent_contact_mobile_import")
     */
    public function agent_contact_mobile_import(ContactManager $contactManager): Response
    {
        /** @var User $agent */
        $agent =  $this->getUser();
        $secteurId = $this->session->get('secteurId');
        $contacts = $_POST['contacts'];

        $contactManager->persistContactInformation($contacts, $agent->getid(), $secteurId);

        return $this->json(
            ['contact' => 'added'],
            200
        );
    }

    /**
     * @Route("/agent/client/contact/add", name="agent_contact_info_add")
     */
    public function agent_contact_info_add(Request $request)
    {
        $contact = new Contact();
        $contactInfo = new ContactInformation();
        $formContact = $this->createForm(ContactInformationType::class, $contactInfo);
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $secteurId = $this->session->get('secteurId');
            if ($secteurId === null) {
                $this->addFlash('danger', "Désolé, une erreur s'est survenue !");
                return $this->redirectToRoute('agent_home');
            }

            $secteur = $this->repoSecteur->find($secteurId);
            $contact->setInformation($contactInfo);
            $contact->setAgent($this->getUser());
            $contact->setStatus(0);
            $contact->setSecteur($secteur);
            if (isset($request->request->get('contact_information')['note'])) {
                $contact->setNote($request->request->get('contact_information')['note']);
            }
            $this->repoContact->add($contact);
            $tags_id = $request->request->get('tags');
            foreach ($tags_id = $tags_id ?? [] as $tag_id) {
                $tag = $this->tagRepository->findOneBy(['id' => $tag_id]);
                $contact->addTag($tag);
            }
            $this->entityManager->save($contact);


            $this->addFlash('success', "Ajout du client avec succès");
            return $this->redirectToRoute('agent_contact_view', ['id' => $contact->getId()]);
        }

        $tags = $this->tagRepository->findAll();
        return $this->render('user_category/agent/contact/add_contact.html.twig', [
            'formContact' => $formContact->createView(),
            'button' => 'Enregistrer',
            'btn_class' =>  'success',
            'tags' => $tags,
            'tags_selectionner' => []
        ]);
    }


    /**
     * @Route("/agent/client/contact/information/{id}/edit", name="agent_contact_info_edit")
     */
    public function agent_contact_info_edit(Request $request, ContactInformation $contactInformation)
    {
        $formContact = $this->createForm(ContactInformationType::class, $contactInformation);
        $contact = $contactInformation->getContact();
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $this->repoContactInfo->add($contactInformation);
            $tags_id = $request->request->get('tags');
            $contact->clearTags();
            foreach ($tags_id = $tags_id ?? [] as $tag_id) {
                $tag = $this->tagRepository->findOneBy(['id' => $tag_id]);
                $contact->addTag($tag);
            }
            if (isset($request->request->get('contact_information')['note'])) {
                $contact->setNote($request->request->get('contact_information')['note']);
            }
            $this->entityManager->save($contact);

            $this->addFlash('success', "Modification du client avec succès");
            return $this->redirectToRoute('agent_contact_view', ['id' => $contact->getId()]);
        }

        $tags = $this->tagRepository->findAll();
        $tags_selectionner = $contact->getTagIds();

        return $this->render('user_category/agent/contact/add_contact.html.twig', [
            'formContact' => $formContact->createView(),
            'button' => 'Modifier',
            'btn_class' =>  'success',
            'label' => 'Modification',
            'tags' => $tags,
            'tags_selectionner' => $tags_selectionner,
            'contact' => $contact
        ]);
    }



    /**
     * @Route("/agent/contact/{id}/delete", name="agent_contact_info_delete")
     */
    public function agent_contact_info_delete(Contact $contact, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->get('_token'))) {
            $this->repoContact->remove($contact);

            $this->addFlash('danger', 'Contact supprimé');
        }
        return $this->redirectToRoute('agent_contact_list');
    }
}
