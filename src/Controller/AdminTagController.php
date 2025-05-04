<?php


namespace App\Controller;


use App\Entity\Tag;
use App\Form\TagType;
use App\Manager\EntityManager;
use App\Repository\TagRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTagController extends AbstractController
{

    /**
     * @var TagRepository
     */
    private $tagRepository;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(TagRepository $tagRepository, EntityManager $entityManager,
        private TranslatorInterface $translator
    )
    {
        $this->tagRepository = $tagRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/tag/list", name="admin_tag_list")
     * @IsGranted("ROLE_ADMINISTRATEUR")
     */
    public function admin_tag_list(PaginatorInterface $paginator, Request $request)
    {
        $tags = $paginator->paginate(
          $this->tagRepository->getAll(),
            $request->query->get('page', 1),
            20
        );

        return $this->render('user_category/admin/tag/list.html.twig', [
            'tags' => $tags
        ]);

    }

    /**
     * @Route("/admin/tag/add", name="admin_tag_add")
     * @Route("/admin/tag/edit/{id}", name="admin_tag_edit")
     * @IsGranted("ROLE_ADMINISTRATEUR")
     * @param Tag|null $tag
     * @param Request $request
     */
    public function admin_tag_form(Request $request, ?Tag $tag = null)
    {
        $tag = $tag ? $tag : new Tag();
        $tagForm = $this->createForm(TagType::class, $tag);
        $tagForm->handleRequest($request);
        if($tagForm->isSubmitted() && $tagForm->isValid()) {
            $this->entityManager->save($tag);
            $message = $request->attributes->get('_route') === 'admin_tag_add' ? 'Tag ajouté avec succès' : 'Tag modifié avec succès';
            $this->addFlash('success', $message);

            return $this->redirectToRoute('admin_tag_list');
        }

        return $this->render('user_category/admin/tag/form.html.twig', [
            'form' => $tagForm->createView()
        ]);

    }

    /**
     * @Route("/admin/tag/delete/{id}", name="admin_tag_delete")
     * @IsGranted("ROLE_ADMINISTRATEUR")
     */
    public function admin_tag_delete(Tag $tag, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $tag->getId(), $request->request->get('_token'))) {
            $this->entityManager->delete($tag);
            $this->addFlash('danger', $this->translator->trans('Le coach a été banni du plateforme'));
        }
        return $this->redirectToRoute('admin_tag_list');
    }

}
