<?php


namespace App\Controller;

use App\Entity\Formation;
use App\Entity\FormationQuizItem;
use App\Form\QuizFormType;
use App\Form\QuizItemFormType;
use App\Repository\FormationQuizItemRepository;
use App\Util\Status;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
  * @Route("/coach/quiz")
  * @IsGranted("ROLE_COACH")
  */
class CoachQuizController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private FormationQuizItemRepository $formationQuizItemRepository){

    }
    /**
     * @Route("/add", name="coach_quiz_add")
     */
   public function quiz_add(Request $request)
   {
        $quiz = new Formation();
        $form = $this->createForm(QuizFormType::class, $quiz);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try{
                $quiz->setStatut(Formation::STATUS_CREATED);
                $quiz->setSecteur($this->getUser()->getSecteurByCoach());
                $quiz->setCoach($this->getUser());
                $quiz->setType(Formation::TYPE_QUIZ);
                $this->entityManager->persist($quiz);
                $this->entityManager->flush();
                $this->addFlash('success', 'Quiz ajouté avec succès');
            } catch(\Exception $e){
                $this->addFlash('danger', $e->getMessage());
            }
        }

        $items = [];
        if($quiz->getId()){
            $items = $this->formationQuizItemRepository->findBy([
                'statut' => Status::VALID, 
                'formation' => $quiz->getId()
            ]);
        }

        return $this->render('formation/quiz/coach_add_quiz.html.twig', [
            'form' => $form->createView(),
            'items' => $items
        ]);
   }

   /**
     * @Route("/{id}/item/add", name="coach_quiz_item_add")
     */
    public function quiz_item_add(Formation $formation, Request $request)
    {
         $item = new FormationQuizItem();
         $item->setFormation($formation);
         $form = $this->createForm(QuizItemFormType::class, $item);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()) {
             try{
                 $item->setStatut(Status::VALID);
                 $this->entityManager->persist($item);
                 $this->entityManager->flush();
                 $this->addFlash('success', 'Question ajoutée avec succès');
             } catch(\Exception $e){
                 $this->addFlash('danger', $e->getMessage());
             }
         }
 
         return $this->render('formation/quiz/coach_add_quiz_item.html.twig', [
             'form' => $form->createView(),
         ]);
    }
}