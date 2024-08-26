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

/**
 * @Route("/admin/contact-example")
 */
class AdminContactExampleController extends AbstractController
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
     * @Route("", name="admin_contact_example_list")
     */
    public function contact_list(Request $request, PaginatorInterface $paginator)
    {

        $query = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Contact::class, 'c')
            ->andwhere('c.isExample = 1')
            ->join('c.information', 'ci')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
        ;
        $contacts = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/contact-example/list_contact_examples.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/add", name="admin_contact_example_add")
     */
    public function contact_info_add(Request $request)
    {
        $contact = new Contact();
        $contactInfo = new ContactInformation();
        $formContact = $this->createForm(ContactInformationType::class, $contactInfo);
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid()) {

            $contact->setInformation($contactInfo);
            $contact->setStatus(0);
            $contact->setIsExample(true);

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


            $this->addFlash('success', "Exemple de contact ajouté avec succès");
            return $this->redirectToRoute('admin_contact_example_view', ['id' => $contact->getId()]);
        }

        $tags = $this->tagRepository->findAll();
        return $this->render('user_category/admin/contact-example/add_contact_example.html.twig', [
            'formContact' => $formContact->createView(),
            'isEdit' => false,
            'tags' => $tags,
            'tags_selectionner' => []
        ]);
    }


    /**
     * @Route("/{id}/edit", name="admin_contact_example_edit")
     */
    public function contact_info_edit(Request $request, ContactInformation $contactInformation)
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
            $contact->setIsExample(true);
            $this->entityManager->save($contact);

            $this->addFlash('success', "Exemple de contact modifié avec succès");
            return $this->redirectToRoute('admin_contact_example_view', ['id' => $contact->getId()]);
        }

        $tags = $this->tagRepository->findAll();
        $tags_selectionner = $contact->getTagIds();

        return $this->render('user_category/admin/contact-example/add_contact_example.html.twig', [
            'formContact' => $formContact->createView(),
            'isEdit' => true,
            'tags' => $tags,
            'tags_selectionner' => $tags_selectionner,
            'contact' => $contact
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_contact_example_delete")
     */
    public function contact_info_delete(Contact $contact, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->get('_token'))) {
            $this->repoContact->remove($contact);

            $this->addFlash('success', 'Exemple de contact supprimé');
        }
        return $this->redirectToRoute('admin_contact_example_list');
    }

    /**
     * @Route("/{id}/view", name="admin_contact_example_view")
     */
    public function contact_view(Contact $contact, Request $request)
    {




        $tags = $contact->getTags() ? $contact->getTags() : [];

        return $this->render('user_category/admin/contact-example/view_contact_example.html.twig', [
            'contact' => $contact,
            'tags' => $tags
        ]);
    }


}
