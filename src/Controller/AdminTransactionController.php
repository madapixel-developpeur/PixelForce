<?php

namespace App\Controller;

use App\Entity\ImplantationAroma;
use App\Entity\KitBaseSecu;
use App\Entity\Produit;
use App\Entity\ProduitDD;
use App\Entity\ProduitFavori;
use App\Entity\ProduitSecu;
use App\Entity\ProduitSecuFavori;
use App\Entity\Secteur;
use App\Entity\User;
use App\Entity\UserTransaction;
use App\Form\ImplantationAromaFilterType;
use App\Form\KitBaseFilterType;
use App\Form\MyProduitDDFilterType;
use App\Form\MyProduitFilterType;
use App\Form\MyProduitSecuFilterType;
use App\Form\RetraitFilterType;
use App\Repository\AgentSecteurRepository;
use App\Repository\KitBaseElmtSecuRepository;
use App\Repository\KitBaseSecuRepository;
use App\Repository\ProduitFavoriRepository;
use App\Repository\ProduitRepository;
use App\Repository\ProduitSecuFavoriRepository;
use App\Repository\UserRepository;
use App\Services\FileHandler;
use App\Services\OrderServiceAroma;
use App\Services\SearchService;
use App\Util\Search\MyCriteriaParam;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/transaction")
 */
class AdminTransactionController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){

    }

    /**
     * @Route("/retrait", name="admin_retrait_list")
     */
    public function retrait(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        
        $page = $request->query->get('page', 1);
        $limit = 20;
        $criteria = [
            ['prop' => 'status'],
            ['prop' => 'dateMin', 'col' => 'createdAt', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'createdAt', 'op' => '<='],
            ['prop' => 'userName', 'col' => "concat(concat(coalesce(u.prenom, ''), ' '), u.nom)", 'alias' => null, 'op' => 'LIKE']
        ];

        $filter = [];

        $form = $this->createForm(RetraitFilterType::class, $filter, [
            'method' => 'GET',
        ]);

        $form->handleRequest($request);
        $filter = $form->getData();
        

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('ut')
            ->from(UserTransaction::class, 'ut')
            ->join('ut.user', 'u')
            ->leftjoin('ut.secteur', 's')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'ut')); 
        $where["where"] .= " and ut.type = :typeRetrait ";  
        $where["params"]['typeRetrait'] = UserTransaction::TYPE_RETRAIT;
        $query->where($where["where"]);
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'ut.createdAt', 'direction' => 'desc']);

        $data = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/admin/transaction/retrait_list.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
        ]);
    }

    // 'validated'|'denied'
    /**
     * @Route("/retrait/{id}/status/{status}", name="admin_retrait_status", methods={"POST"})
     */
    public function changeStatus(Request $request, UserTransaction $userTransaction, string $status): Response
    {
        if($status === 'validated' || $status === 'denied'){
            try{
                $userTransaction->setStatus($status === 'validated' ? UserTransaction::STATUS_VALID : UserTransaction::STATUS_CANCELLED);
                $this->entityManager->persist($userTransaction);
                $this->entityManager->flush();
                $this->addFlash('success', 'Retrait '.($status === 'validated' ? 'validé':'refusé').' avec succès'); 
            } catch(Exception $ex){
                $this->addFlash('danger',$ex->getMessage());
            } 
        }
        return $this->redirectToRoute('admin_retrait_list');
    }
}
