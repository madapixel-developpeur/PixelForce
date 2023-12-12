<?php

namespace App\Controller\DemandeDevis;

use App\Entity\DemandeDevis;
use App\Entity\Devis;
use App\Entity\OrderDigital;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Produit;
use App\Entity\ProduitDD;
use App\Entity\User;
use App\Form\DemandeDevisFilterType;
use App\Form\DemandeDevisFormType;
use App\Form\DevisType;
use App\Form\MyProductFilter;
use App\Form\MyProduitFilterType;
use App\Form\ProduitFormType;
use App\Form\ProduitFilterType;
use App\Repository\DemandeDevisRepository;
use App\Repository\DevisRepository;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;

use App\Repository\ProduitRepository;
use App\Repository\SecteurRepository;
use App\Repository\UserRepository;
use App\Services\DemandeDevisService;
use Knp\Component\Pager\PaginatorInterface;
use App\Services\SearchService;
use App\Services\ExcelService;
use App\Services\FileHandler;
use App\Services\StripeService;
use App\Util\GenericUtil;
use App\Util\PopupUtil;
use App\Util\Search\MyCriteriaParam;
use DateTime;
use Exception;
use SessionIdInterface;
use Stripe\Product;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @Route("/client/{token}/demandedevis")
 */
class DemandeDevisControllerClient extends AbstractController
{
    private $entityManager;
    private $demandeDevisRepository;
    private $fileHandler;
    private $secteurRepository;
    private $session;
    private $userRepository;
    private $repoDevis;
    private $demandeDevisService;

    public function __construct(UserRepository $userRepository, SessionInterface $session, EntityManagerInterface $entityManager, DemandeDevisRepository $demandeDevisRepository, FileHandler $fileHandler, SecteurRepository $secteurRepository, DevisRepository $repoDevis, DemandeDevisService $demandeDevisService){
        $this->entityManager = $entityManager;
        $this->demandeDevisRepository = $demandeDevisRepository;
        $this->fileHandler = $fileHandler;
        $this->secteurRepository = $secteurRepository;
        $this->session = $session;
        $this->userRepository = $userRepository;
        $this->repoDevis = $repoDevis;
        $this->demandeDevisService = $demandeDevisService;
    }

   /**
     * @Route("/", name="client_demandedevis_list")
     */
    public function index($token, Request $request, PaginatorInterface $paginator, SearchService $searchService): Response
    {
        $secteurId = $this->session->get('secteurId');
        $agent = $this->userRepository->findAgentByUsername($token);
        $page = $request->query->get('page', 1);
        $limit = 5;
        $criteria = [
            ['prop' => 'status'],
            ['prop' => 'nomProduit', 'col' => 'nom', 'op' => 'LIKE', 'alias' => 'p'],
            ['prop' => 'dateMin', 'col' => 'dateDemande', 'op' => '>='],
            ['prop' => 'dateMax', 'col' => 'dateDemande', 'op' => '<='],
            ['prop' => 'user', 'col' => 'id', 'alias' => 'c']
        ];

        $filter = [];

        $form = $this->createForm(DemandeDevisFilterType::class, $filter, [
            'method' => 'GET',
        ]);
        $form->handleRequest($request);
        $filter = $form->getData();
        $filter["user"] = ((object)$this->getUser())->getId();

        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('d')
            ->from(DemandeDevis::class, 'd')
            ->join('d.client', 'c')
            ->join('d.agent', 'a')
            ->join('d.secteur', 's')
            ->join('d.produit', 'p')
        ;  

        $where =  $searchService->getWhere($filter, new MyCriteriaParam($criteria, 'd'));   
        $query->where($where["where"]." and a.id = :agentId and s.id = :secteurId ");
        $where["params"]["agentId"] = $agent->getId();
        $where["params"]["secteurId"] = $secteurId;
        $searchService->setAllParameters($query, $where["params"]);
        $searchService->addOrderBy($query, $filter, ['sort' => 'd.dateDemande', 'direction' => 'desc']);

        $ddList = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/client/dd/demandedevis/demandedevis_list.html.twig', [
            'ddList' => $ddList,
            'form' => $form->createView(),
            'token' => $token,
            'agent' => $agent
        ]);

    }
    

    /**
     * @Route("/{id}/new", name="client_demandedevis_new")
     */
    public function new($token, ProduitDD $produit, Request $request): Response
    {
        $user = (object)$this->getUser();
        $secteurId = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->find($secteurId);
        $agent = $this->userRepository->findAgentByUsername($token);
        $isEdit = false;
        $error = null;
        $dd = new DemandeDevis();
        $dd->setNom($user->getNom());
        $dd->setPrenom($user->getPrenom());
        $dd->setTelephone($user->getTelephone());
        $dd->setEmail($user->getEmail());
        $form = $this->createForm(DemandeDevisFormType::class, $dd);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $files = [];

                $data = $form->get('files')->getData();
                for($i=0; $i<count($data); $i++){
                    $filename = $this->fileHandler->upload($data[$i], "dd/".date('Y-m-d-H-i-s'));
                    $files[] = $filename;
                }

                $dd->setFiles($files);
                $dd->setStatut(1);
                $dd->setSecteur($secteur);
                $dd->setAgent($agent);
                $dd->setClient($user);
                $dd->setProduit($produit);
                $dd->setDateDemande(new DateTime());
                $this->entityManager->persist($dd);
                $this->entityManager->flush();

                return $this->redirectToRoute('client_demandedevis_list', ['token' => $token]);
                // return $this->redirectToRoute('client_demandedevis_fiche', ['token' => $token, 'id' => $dd->getId()]);
            } catch(Exception $ex){
                $error = $ex->getMessage();
            }
        }

        return $this->render('user_category/client/dd/demandedevis/demandedevis_form.html.twig',[
            'form' => $form->createView(),
            'error' => $error,
            'isEdit' => $isEdit,
            'produit' => $produit,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'agent' => $agent,
            'token' => $token
        ]);
    }

    /**
     * @Route("/{id}/fiche", name="client_demandedevis_fiche")
     */
    public function fiche($token, DemandeDevis $dd): Response
    {
        $secteurId = $this->session->get('secteurId');
        $secteur = $this->secteurRepository->find($secteurId);
        $agent = $this->userRepository->findAgentByUsername($token);
        $allDevis = $this->repoDevis->findBy(['demandeDevis'=> $dd]);

        return $this->render('user_category/client/dd/demandedevis/demandedevis_details.html.twig',[
            'dd' => $dd,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
            'agent' => $agent,
            'error' => null,
            'token' => $token,
            'allDevis' => $allDevis
        ]);
    }

    
}
