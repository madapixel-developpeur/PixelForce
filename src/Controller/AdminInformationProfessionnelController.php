<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Secteur;
use App\Entity\ProduitDD;
use App\Entity\KitBaseSecu;
use App\Entity\ProduitSecu;
use App\Entity\ProduitFavori;
use App\Services\FileHandler;
use App\Entity\UserInformation;
use App\Entity\UserTransaction;
use App\Form\KitBaseFilterType;
use App\Form\RetraitFilterType;
use App\Services\SearchService;
use App\Entity\ImplantationAroma;
use App\Entity\ProduitSecuFavori;
use App\Form\MyProduitFilterType;
use App\Repository\UserRepository;
use App\Form\MyProduitDDFilterType;
use App\Services\OrderServiceAroma;
use App\Util\Search\MyCriteriaParam;
use App\Form\MyProduitSecuFilterType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ImplantationAromaFilterType;
use App\Repository\KitBaseSecuRepository;
use App\Repository\AgentSecteurRepository;
use App\Repository\ProduitFavoriRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\KitBaseElmtSecuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProduitSecuFavoriRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/professionnel/information")
 */
class AdminInformationProfessionnelController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){

    }

    /**
     * @Route("/retrait", name="admin_information_professionnel_list")
     */
    public function retrait(Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        
        $page = $request->query->get('page', 1);
        $limit = 20;
        $criteria = [
            ['prop' => 'dateMin', 'col' => 'validationDate', 'op' => '>=', 'alias' => 'inf', ],
            ['prop' => 'dateMax', 'col' => 'validationDate', 'op' => '<=', 'alias' => 'inf', ],
            ['prop' => 'userName', 'col' => "concat(concat(coalesce(u.prenom, ''), ' '), u.nom)", 'alias' => null, 'op' => 'LIKE'],
        ];

        $filter = [];

        $form = $this->createForm(RetraitFilterType::class, $filter, [
            'method' => 'GET',
        ])->remove('sort')->remove('rib')->remove('direction')->remove('status');

        $form->handleRequest($request);
        $filter = $form->getData();
        

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('u','inf.validationDate')
            ->from(User::class, 'u')
            ->join('u.information','inf')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'u')); 
        $where["where"] .= " and u.profesionnalInformationState = :stateInformation ";  
        $where["params"]['stateInformation'] = User::INFORMATION_PENDING;
        $query->where($where["where"]);


        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'inf.validationDate', 'direction' => 'desc']);

        $data = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/admin/professionnel/information/pro_information_list.html.twig', [
            'data' => $data,
            'form' => $form->createView(),
        ]);
    }

      /**
     * @Route("/{id}/view", name="admin_professionnel_information_view")
     */
    public function view(User $user)
    {
        $userInformation = $user->getInformation();
        return $this->render('user_category/admin/professionnel/information/pro_information_view.html.twig', [
            'userInformation' => $userInformation,
            'user' => $user
        ]);
    }

     // 'validated'|'denied'
    /**
     * @Route("/{id}", name="admin_professionnel_information_status", methods={"POST"})
     */
    public function changeStatus(Request $request, User $user): Response
    {
        try{
            $status = $request->get('status');
            $user->setProfesionnalInformationState($status);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'Informations '.($status == User::INFORMATION_VALIDATED ? 'validés':'refusés').' avec succès'); 
        } catch(Exception $ex){
            $this->addFlash('danger',$ex->getMessage());
        } 
        return $this->redirectToRoute('admin_information_professionnel_list');
    }

}
