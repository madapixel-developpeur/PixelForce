<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Services\FileHandler;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use App\Entity\CatalogueProductSector;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CatalogueProductSectorFilterType;
use App\Form\CatalogueProductSectorFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/coach/catalogue/product-sector')]
class CoachCatalogueProductSectorController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileHandler $fileHandler,
        private TranslatorInterface $translator,
    )
    {

    }

   #[Route('/add', name: 'app_catalogues_product_sector_add')]
    public function add(Request $request): Response
    {
        $product = new CatalogueProductSector();
        $form = $this->createForm(CatalogueProductSectorFormType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $image = $form->get('image')->getData();
                if ($image) {
                    $filePath = $this->fileHandler->upload($image, "catalogues-images/");
                    $product->setImage($filePath);
                }
                $product->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $this->entityManager->persist($product);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('Produit ajoutée avec succès'));
                return $this->redirectToRoute('app_coach_catalogue_product_sector_list');
            } catch (\Exception $ex) {
                // $this->addFlash('danger', $ex->getMessage());
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }

        return $this->render('user_category/coach/catalogues-product-sector/catalogues_product_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => false,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_catalogues_product_edit')]
    public function edit(CatalogueProductSector $product, Request $request): Response
    {
        $form = $this->createForm(CatalogueProductSectorFormType::class, $product,[
            'isEdit' => true
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                 $image = $form->get('image')->getData();
                if ($image) {
                    $filePath = $this->fileHandler->upload($image, "catalogues-images/");
                    $product->setImage($filePath);
                }
                $this->entityManager->persist($product);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('Produit modifiée avec succès'));
                return $this->redirectToRoute('app_coach_catalogue_product_sector_list');
            } catch (\Exception $ex) {
                $this->addFlash('danger', $ex->getMessage());
            }
        }

        return $this->render('user_category/coach/catalogues-product-sector/catalogues_product_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => true,
            "product" => $product
        ]);
    }


   
    #[Route('/{id}/delete', name: 'app_catalogues_product_delete', methods: ['POST'])]
    public function delete(CatalogueProductSector $product): Response
    {
        try {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
            $this->addFlash('success', $this->translator->trans('Produit supprimée avec succès'));
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('app_coach_catalogue_product_sector_list');

    }



    #[Route('/', name: 'app_coach_catalogue_product_sector_list')]
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 20;

        $criteria = [
            ['prop' => 'title', 'op' => 'LIKE'],
            ['prop' => 'shortDescription', 'op' => 'LIKE'],
            ['prop' => 'redirectionUrl','op' => '='],
        ];  

        $filter = [];

        $form = $this->createForm(CatalogueProductSectorFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();

    
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('a')
            ->from(CatalogueProductSector::class, 'a');

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'a'));
        $query->where($where["where"] . " and a.secteur = :secteurId ");
        $where["params"]["secteurId"] = $this->getUser()->getUniqueCoachSecteur()?->getId();
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'a.id', 'direction' => 'ASC']);

        $announcements = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/catalogues-product-sector/catalogues_product_list.html.twig', [
            'result' => $announcements,
            'form' => $form->createView(),
            'page' => $page
        ]);

    }

}