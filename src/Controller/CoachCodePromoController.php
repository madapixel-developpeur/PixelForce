<?php

namespace App\Controller;

use App\Entity\CodePromo;
use App\Form\CodePromoType;
use App\Form\CodePromoFormType;
use App\Services\SearchService;
use App\Entity\CodePromoCountry;
use App\Form\CodePromoFilterType;
use App\Util\Search\MyCriteriaParam;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/coach/code-promo')]
class CoachCodePromoController extends AbstractController
{


    
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

     /**
     * @Route("/", name="code_promo_list")
     */
    public function index(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 20;

        $criteria = [
            ['prop' => 'title', 'op' => 'LIKE'],
            ['prop' => 'code', 'op' => 'LIKE'],
            ['prop' => 'minDiscount', 'op' => '>=', "col" => "discount"],
            ['prop' => 'maxDiscount', 'op' => '<=', "col" => "discount"],
            ['prop' => 'country', 'op' => 'LIKE', "col" => "countryCode","alias"=> 'cc'],
        ];  

        $filter = [];

        $form = $this->createForm(CodePromoFilterType::class, $filter, [
            'method' => 'GET'
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();
    
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('a')
            ->from(CodePromo::class, 'a')
            ->leftJoin('a.codePromoCountries', 'cc');

        $where = $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'a'));
        $query->where($where["where"] . " and a.secteur = :secteurId ");
        $where["params"]["secteurId"] = $this->getUser()->getUniqueCoachSecteur()?->getId();
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'a.startDate', 'direction' => 'DESC']);

        $codePromos = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/coach/code-promo/code_promo_list.html.twig', [
            'result' => $codePromos,
            'form' => $form->createView(),
            'page' => $page
        ]);

    }


    /**
     * @Route("/new", name="code_promo_new")
     */
    public function new(Request $request): Response
    {
        $codePromo = new CodePromo();
        $form = $this->createForm(CodePromoFormType::class, $codePromo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->beginTransaction();

                $selectedCountryCodes = $form->get('countries')->getData();

                foreach ($selectedCountryCodes as $countryCode) {
                    $codePromoCountry = new CodePromoCountry();
                    $codePromoCountry->setCountryCode($countryCode);
                    $codePromoCountry->setCodePromo($codePromo);
                    $this->entityManager->persist($codePromoCountry);
                }

                $codePromo->setSecteur($this->getUser()->getUniqueCoachSecteur());
                $this->entityManager->persist($codePromo);
                $this->entityManager->flush();
                $this->entityManager->commit();


                $this->addFlash('success', 'Code promo ajouté avec succès');
                return $this->redirectToRoute('code_promo_list');
            } catch (\Exception $ex) {
                if ($this->entityManager->getConnection()->isTransactionActive()) {
                    $this->entityManager->rollback();
                }
                $this->addFlash('danger',$_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }

        return $this->render('user_category/coach/code-promo/code_promo_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="code_promo_edit")
     */
    public function edit(Request $request, CodePromo $codePromo): Response
    {
        $form = $this->createForm(CodePromoFormType::class, $codePromo, [
            'selected_countries' => $codePromo->getCountryCodeList(), 
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $this->entityManager->beginTransaction();

                $selectedCountryCodes = $form->get('countries')->getData();
                $existingCountries = $codePromo->getCodePromoCountries()->toArray();
                foreach ($existingCountries as $existingCountry) {
                    if (!in_array($existingCountry->getCountryCode(), $selectedCountryCodes)) {
                        $codePromo->removeCodePromoCountry($existingCountry);
                        $this->entityManager->remove($existingCountry);
                    }
                }

                foreach ($selectedCountryCodes as $selectedCountryCode) {
                    $found = false;
                    foreach ($existingCountries as $existingCountry) {
                        if ($existingCountry->getCountryCode() === $selectedCountryCode) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $codePromoCountry = new CodePromoCountry();
                        $codePromoCountry->setCountryCode($selectedCountryCode);
                        $codePromoCountry->setCodePromo($codePromo);
                        $this->entityManager->persist($codePromoCountry);
                    }
                }
                $this->entityManager->flush();
                $this->entityManager->commit();
                $this->addFlash('success', 'Code promo modifié avec succès');
                return $this->redirectToRoute('code_promo_list');
            } catch (\Throwable $th) {
                if ($this->entityManager->getConnection()->isTransactionActive()) {
                    $this->entityManager->rollback();
                }
                $this->addFlash('danger',$_ENV['CUSTOM_ERROR_MESSAGE']);
            }
            $this->entityManager->flush();

            return $this->redirectToRoute('code_promo_list');
        }

        return $this->render('user_category/coach/code-promo/code_promo_form.html.twig', [
            'form' => $form->createView(),
            'codePromo' => $codePromo,
        ]);
    }


    #[Route('/{id}/delete', name: 'code_promo_delete', methods: ['POST'])]
    public function delete(CodePromo $codePromo): Response
    {
        try {
            $this->entityManager->remove($codePromo);
            $this->entityManager->flush();
            $this->addFlash('success', 'Code promo supprimé avec succès');
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('code_promo_list');

    }


    
}