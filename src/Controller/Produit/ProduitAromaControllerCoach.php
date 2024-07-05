<?php

namespace App\Controller\Produit;

use App\Entity\ProduitAroma;
use App\Form\ProduitAromaFilterType;
use App\Form\ProduitAromaFormType;
use App\Services\FileHandler;
use App\Services\SearchService;
use App\Util\PopupUtil;
use App\Util\Search\MyCriteriaParam;
use App\Util\Status;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route(path: '/coach/aroma/product')]
class ProduitAromaControllerCoach extends AbstractController
{
    private $entityManager;
    private $fileHandler;


    public function __construct(
        EntityManagerInterface $entityManager,
        FileHandler $fileHandler
    ) {
        $this->entityManager = $entityManager;
        $this->fileHandler = $fileHandler;
    }


    #[Route(path: '/', name: 'admin_aroma_product_index')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 6;
        $criteria = [
            ['prop' => 'nom', 'op' => 'LIKE'],
            ['prop' => 'prixMin', 'op' => '>=', 'col' => 'prix', 'case_sensitive' => true],
            ['prop' => 'prixMax', 'op' => '<=', 'col' => 'prix', 'case_sensitive' => true],
        ];

        $filter = [];

        $form = $this->createForm(ProduitAromaFilterType::class, $filter, [
            'method' => 'GET',
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(ProduitAroma::class, 'p');

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'p'));
        $query->where($where["where"] . " and p.statut != 0 ");
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'p.nom', 'direction' => 'asc']);

        $productList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/aroma/product/admin_product_index.html.twig', [
            'productList' => $productList,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'admin_aroma_product_new')]
    public function new(Request $request): Response
    {
        $isEdit = false;
        $product = new ProduitAroma();

        $form = $this->createForm(ProduitAromaFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $imageFile = $form->get('imageFile')->getData();
                if ($imageFile) {
                    $photo = $this->fileHandler->upload($imageFile, "images\products\aroma");
                    $product->setImage($photo);
                }
                $product->setStatut(Status::VALID);
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $this->addFlash('success', 'Produit ajouté');
                return $this->redirectToRoute('admin_aroma_product_index');
            } catch (Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
        }


        return $this->render('user_category/coach/aroma/product/admin_product_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => $isEdit,
            'product' => $product
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_aroma_product_edit')]
    public function edit(ProduitAroma $product, Request $request): Response
    {
        $isEdit = true;

        $form = $this->createForm(ProduitAromaFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $imageFile = $form->get('imageFile')->getData();
                if ($imageFile) {
                    $photo = $this->fileHandler->upload($imageFile, "images\products\aroma");
                    $product->setImage($photo);
                }
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                $this->addFlash('success', 'Produit modifié');
                return $this->redirectToRoute('admin_aroma_product_index');
            } catch (Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
        }


        return $this->render('user_category/coach/aroma/product/admin_product_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => $isEdit,
            'product' => $product
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_aroma_product_delete')]
    public function delete(ProduitAroma $product): Response
    {
        try {
            $product->setStatut(Status::INVALID);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'Produit supprimé');
        } catch (Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('admin_aroma_product_index');
    }

    #[Route('/details/{id}', name: 'admin_aroma_product_details')]
    public function details(ProduitAroma $product): Response
    {
        return $this->render('user_category/coach/aroma/product/admin_product_details.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/popup', name: 'admin_aroma_product_popup')]
    public function popup(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $opener = $request->query->get('opener', '');
        $popup = $request->query->get('popup', '');
        $mapPopup = PopupUtil::getMapPopup($opener, $popup);

        $page = $request->query->get('page', 1);
        $limit = 6;
        $criteria = [
            ['prop' => 'nom', 'op' => "LIKE"],
            ['prop' => 'prixMin', 'col' => 'cost', 'op' => '>=', 'case_sensitive' => true],
            ['prop' => 'prixMax', 'col' => 'cost', 'op' => '<=', 'case_sensitive' => true]
        ];

        $filter = [];

        $form = $this->createForm(ProduitAromaFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('p')
            ->from(ProduitAroma::class, 'p');

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'p'));
        $query->where($where["where"] . " and p.statut != 0 ");
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'p.nom', 'direction' => 'asc']);

        $productList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/aroma/product/admin_product_popup.html.twig', [
            'productList' => $productList,
            'form' => $form->createView(),
            'mapPopup' => $mapPopup,
            'opener' => $opener,
            'popup' => $popup
        ]);
    }
}
