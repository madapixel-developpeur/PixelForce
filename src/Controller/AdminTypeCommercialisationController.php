<?php


namespace App\Controller;


use App\Entity\TypeSecteur;
use App\Manager\EntityManager;
use App\Form\CommercialisationType;
use App\Repository\TypeSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminTypeCommercialisationController extends AbstractController
{
    /**
     * @var TypeSecteurRepository
     */
    private $typeSecteurRepository;
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(TypeSecteurRepository $typeSecteurRepository, PaginatorInterface $paginator, EntityManager $entityManager,
        private TranslatorInterface $translator
    )
    {
        $this->typeSecteurRepository = $typeSecteurRepository;
        $this->paginator = $paginator;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/typeCommercialisation/list", name="admin_typeCommercialisation_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function admin_typeCommercialisation_list(Request $request)
    {
        $typeSecteurs = $this->paginator->paginate(
            $this->typeSecteurRepository->getAll(),
            $request->query->get('page', 1),
            20
        );
        return $this->render('user_category/admin/typeCommercialisation/list.html.twig', [
            'typeSecteurs' => $typeSecteurs
        ]);
    }

    /**
     * @Route("/admin/typeCommercialisation/add", name="admin_typeCommercialisation_add")
     */
    public function admin_typeCommercialisation_add(Request $request)
    {
        $typeSecteur = new TypeSecteur();
        $form = $this->createForm(CommercialisationType::class, $typeSecteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->save($typeSecteur);
            $this->addFlash('success', $this->translator->trans("Ajout d'une type de commercialisation avec succès"));
            return $this->redirectToRoute('admin_typeCommercialisation_list');
        }

        return $this->render('user_category/admin/typeCommercialisation/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/typeCommercialisation/edit/{id}", name="admin_typeCommercialisation_edit")
     */
    public function admin_typeCommercialisation_edit(Request $request, TypeSecteur $typeSecteur)
    {
        $form = $this->createForm(CommercialisationType::class, $typeSecteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->save($typeSecteur);
            $this->addFlash('success', $this->translator->trans("Modification type de commercialisation avec succès"));
            return $this->redirectToRoute('admin_typeCommercialisation_list');
        }

        return $this->render('user_category/admin/typeCommercialisation/edit.html.twig', [
            'form' => $form->createView(),
            'typeSecteur' => $typeSecteur
        ]);
    }

    /**
     * @Route("/admin/typeCommercialisation/delete/{id}", name="admin_typeCommercialisation_delete")
     */
    public function admin_typeCommercialisation_delete(TypeSecteur $typeSecteur, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $typeSecteur->getId(), $request->get('_token'))) {
            $this->entityManager->delete($typeSecteur);
            $this->addFlash( 'danger', 'Type de commercialisation supprimée');
        }
        return $this->redirectToRoute('admin_typeCommercialisation_list');
    }


}