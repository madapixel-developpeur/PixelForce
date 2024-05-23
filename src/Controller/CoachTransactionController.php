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
 * @Route("/coach/transaction")
 */
class CoachTransactionController extends AbstractController
{
    public function __construct(private SessionInterface $session, private EntityManagerInterface $entityManager, private UserTransactionRepository $userTransactionRepository, private SecteurRepository $secteurRepository){

    }
    /**
     * @Route("/retrait", name="coach_transaction_retrait")
     */
    public function retrait(Request $request,PaginatorInterface $paginator){
        
        $user = (object)$this->getUser();
        $secteur = $user->getUniqueCoachSecteur();
        $form = $this->createForm(RetraitFormType::class,null,[ 'rib' => $user->getRib() ]);
        $form->handleRequest($request);
        $userSolde = $this->userTransactionRepository->getSolde($user, [$secteur->getId()]);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $data = $form->getData();
                $countPendintRetrait = $this->userTransactionRepository->getNumberOfPendingRetrait($user, [$secteur->getId()]);
                if($countPendintRetrait){
                    throw new \Exception('Une demande de retrait est déjà en cours.');
                }
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
                if(strcasecmp($data->getRib(), $user->getRib()) != 0){
                    return $this->redirectToRoute('coach_change_rib',['newRib'=>$data->getRib()]);  
                }
            } catch(\Exception $e){
                $this->addFlash("danger", $e->getMessage());
            }
        }
        $history = $paginator->paginate(
            $this->userTransactionRepository->getHistory($user,  [$secteur->getId()]),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/coach/transaction/retrait.html.twig', [
            'form' => $form->createView(),  
            'solde'  => $userSolde    ,
            'history'  => $history,          
        ]);
    }

    /**
     * @Route("/changer-rib/{newRib}", name="coach_change_rib")
    */
    public function changeRibBasedOnLastTransaction(Request $request,$newRib){
        $user = (object)$this->getUser();
        $oldRib = $user->getRib();
        if ($request->getMethod() === Request::METHOD_POST) {
            $decision = $request->request->get('decision');
            if($decision == "1"){
                $user->setRib($newRib);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $this->addFlash("success", "RIB changé avec succès");
            }
            return $this->redirectToRoute('coach_transaction_retrait');  
        }
        return $this->render('user_category/coach/transaction/change-rib-confirmation.html.twig',[
            'newRib' => $newRib,  
            'oldRib'  => $oldRib,
        ]);
    }
}