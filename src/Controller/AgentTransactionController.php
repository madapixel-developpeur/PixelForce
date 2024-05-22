<?php


namespace App\Controller;

use App\Form\RetraitFormType;
use App\Entity\UserTransaction;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\UserTransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
/**
 * @Route("/agent/transaction")
 */
class AgentTransactionController extends AbstractController
{
    public function __construct(private SessionInterface $session, private EntityManagerInterface $entityManager, private UserTransactionRepository $userTransactionRepository, private SecteurRepository $secteurRepository){

    }
    /**
     * @Route("/retrait", name="agent_transaction_retrait")
     */
    public function retrait(Request $request,PaginatorInterface $paginator){
        $secteurId =  $this->session->get('secteurId');
        $secteur = $this->secteurRepository->find($secteurId);
        $form = $this->createForm(RetraitFormType::class);
        $user = $this->getUser();
        $form->handleRequest($request);
        $userSolde = $this->userTransactionRepository->getSolde($user, [$secteurId]);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $countPendintRetrait = $this->userTransactionRepository->getNumberOfPendingRetrait($user, [$secteurId]);
                if($countPendintRetrait){
                    throw new \Exception('Une demande de retrait est déjà en cours.');
                }
                $data = $form->getData();
                if($data->getAmount() > $userSolde){
                    throw new \Exception('Solde insuffisant');
                }
                $data->setCreatedAt(new \DateTimeImmutable());
                $data->setSecteur($secteur);
                $data->setSortie(true);
                $data->setType(UserTransaction::TYPE_RETRAIT);
                $data->setUser($user);
                $data->setStatus(UserTransaction::STATUS_CREATED);
                $this->entityManager->persist($data);
                $this->entityManager->flush();

                $this->addFlash("success", "Retrait effectué avec succès");
            } catch(\Exception $e){
                $this->addFlash("danger", $e->getMessage());
            }
        }
        $history = $paginator->paginate(
            $this->userTransactionRepository->getHistory($user, [$secteurId]),
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('user_category/agent/transaction/retrait.html.twig', [
            'form' => $form->createView(),   
            'solde'  => $userSolde,      
            'history'  => $history,      
        ]);
    }
}