<?php


namespace App\Controller;

use App\Entity\UserTransaction;
use App\Form\RetraitFormType;
use App\Repository\SecteurRepository;
use App\Repository\UserTransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\Routing\Annotation\Route;
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
    public function retrait(Request $request){
        
        $user = (object)$this->getUser();
        $secteur = $user->getUniqueCoachSecteur();
        $form = $this->createForm(RetraitFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $data = $form->getData();
                if($data->getAmount() > $this->userTransactionRepository->getSolde($user, [$secteur->getId()])){
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

        return $this->render('user_category/coach/transaction/retrait.html.twig', [
            'form' => $form->createView(),          
        ]);
    }
}