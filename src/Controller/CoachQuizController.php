<?php


namespace App\Controller;

use App\Entity\Formation;
use App\Entity\FormationQuizItem;
use App\Entity\FormationQuizItemChoice;
use App\Form\QuizFormType;
use App\Form\QuizItemChoiceFormType;
use App\Form\QuizItemFormType;
use App\Repository\FormationQuizItemChoiceRepository;
use App\Repository\FormationQuizItemRepository;
use App\Util\Status;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;

/**
  * @Route("/coach/quiz")
  * @IsGranted("ROLE_COACH")
  */
class CoachQuizController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private FormationQuizItemRepository $formationQuizItemRepository, private FormationQuizItemChoiceRepository $formationQuizItemChoiceRepository){

    }
    /**
     * @Route("/add", name="coach_quiz_add")
     */
   public function quiz_add(Request $request)
   {
        $quiz = new Formation();
       return $this->quiz_save($quiz, $request);
   }

   /**
     * @Route("/{id}/edit", name="coach_quiz_edit")
     */
    public function quiz_edit(Formation $quiz, Request $request)
    {
        return $this->quiz_save($quiz, $request);
    }

   private function quiz_save(Formation $quiz, Request $request){
    $isEdit = $quiz->getId() !== null;
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
            $this->addFlash('success', $isEdit ? 'Quiz modifié avec succès' : 'Quiz ajouté avec succès');
            return $this->redirectToRoute('coach_quiz_details', ['id'=> $quiz->getId()]);
        } catch(\Exception $e){
            $this->addFlash('danger', $e->getMessage());
        }
    }

    return $this->render('formation/quiz/coach_add_quiz.html.twig', [
        'form' => $form->createView(),
    ]);
   }

   
   /**
     * @Route("/{id}/delete", name="coach_quiz_delete", methods={"POST"})
     */
    public function quiz_delete(Request $request, Formation $formation): Response
    {
            try{
                $formation->setStatut(Formation::STATUS_DELETED);
                $this->entityManager->persist($formation);
                $this->entityManager->flush();
                $this->addFlash('success', 'Quiz supprimé avec succès'); 
            } catch(Exception $ex){
                $this->addFlash('danger',$ex->getMessage());
            } 
        
        return $this->redirectToRoute('coach_formation_list');
    }

   /**
     * @Route("/{id}/details", name="coach_quiz_details")
     */
    public function quiz_details(Formation $quiz)
    {
         
 
         $items = $this->formationQuizItemRepository->findBy([
            'statut' => Status::VALID, 
            'formation' => $quiz->getId()
        ]);
         

         return $this->render('formation/quiz/coach_details_quiz.html.twig', [
             'quiz' => $quiz,
             'items' => $items
         ]);
    }

   /**
     * @Route("/{id}/item/add", name="coach_quiz_item_add")
     */
    public function quiz_item_add(Formation $formation, Request $request)
    {
         $item = new FormationQuizItem();
         return $this->quiz_item_save($formation, $item, $request);
    }

    /**
     * @Route("/item/{id}/edit", name="coach_quiz_item_edit")
     */
    public function quiz_item_edit(FormationQuizItem $item, Request $request)
    {
         return $this->quiz_item_save($item->getFormation(), $item, $request);
    }

    private function quiz_item_save(Formation $formation, FormationQuizItem $item, Request $request){
        $isEdit = $item->getId() !== null;
        $item->setFormation($formation);
         $form = $this->createForm(QuizItemFormType::class, $item);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()) {
             try{
                 $item->setStatut(Status::VALID);
                 $this->entityManager->persist($item);
                 $this->entityManager->flush();
                 $this->addFlash('success', $isEdit ? 'Question modifiée avec succès':'Question ajoutée avec succès');
                 return $this->redirectToRoute('coach_quiz_item_details', ['id'=> $item->getId()]);
             } catch(\Exception $e){
                 $this->addFlash('danger', $e->getMessage());
             }
         }
 
         return $this->render('formation/quiz/coach_add_quiz_item.html.twig', [
             'form' => $form->createView(),
         ]);
    }

    /**
     * @Route("/item/{id}/details", name="coach_quiz_item_details")
     */
    public function quiz_item_details(FormationQuizItem $item)
    {
         
 
         $choices = $this->formationQuizItemChoiceRepository->findBy([
            'statut' => Status::VALID, 
            'formationQuizItem' => $item->getId()
        ]);
         

         return $this->render('formation/quiz/coach_details_quiz_item.html.twig', [
             'item' => $item,
             'choices' => $choices
         ]);
    }

    /**
     * @Route("/item/{id}/delete", name="coach_quiz_item_delete", methods={"POST"})
     */
    public function quiz_item_delete(Request $request, FormationQuizItem $item): Response
    {
            try{
                $item->setStatut(Status::INVALID);
                $this->entityManager->persist($item);
                $this->entityManager->flush();
                $this->addFlash('success', 'Question supprimée avec succès'); 
            } catch(Exception $ex){
                $this->addFlash('danger',$ex->getMessage());
            } 
        
        return $this->redirectToRoute('coach_quiz_details', ['id'=> $item->getFormation()->getId()]);
    }

    /**
     * @Route("/choice/{id}/delete", name="coach_quiz_item_choice_delete", methods={"POST"})
     */
    public function quiz_item_choice_delete(Request $request, FormationQuizItemChoice $choice): Response
    {
            try{
                $choice->setStatut(Status::INVALID);
                $this->entityManager->persist($choice);
                $this->entityManager->flush();
                $this->addFlash('success', 'Choix supprimé avec succès'); 
            } catch(Exception $ex){
                $this->addFlash('danger',$ex->getMessage());
            } 
        
        return $this->redirectToRoute('coach_quiz_item_details', ['id'=> $choice->getFormationQuizItem()->getId()]);
    }

    /**
     * @Route("/{id}/choice/add", name="coach_quiz_item_choice_add")
     */
    public function quiz_item_choice_add(FormationQuizItem $item, Request $request)
    {
         $choice = new FormationQuizItemChoice();
         return $this->quiz_item_choice_save($item, $choice, $request);
    }

    /**
     * @Route("/choice/{id}/edit", name="coach_quiz_item_choice_edit")
     */
    public function quiz_item_choice_edit(FormationQuizItemChoice $choice, Request $request)
    {
         return $this->quiz_item_choice_save($choice->getFormationQuizItem(), $choice, $request);
    }

    private function quiz_item_choice_save(FormationQuizItem $item, FormationQuizItemChoice $choice, Request $request){
        $isEdit = $choice->getId() !== null;
        $choice->setFormationQuizItem($item);
         $form = $this->createForm(QuizItemChoiceFormType::class, $choice);
         $form->handleRequest($request);
         if($form->isSubmitted() && $form->isValid()) {
             try{
                if($choice->isVrai() && !$item->isMultipleChoix()){
                    $choices = $this->formationQuizItemChoiceRepository->findBy([
                        'statut' => Status::VALID, 
                        'formationQuizItem' => $item->getId()
                    ]);
                    foreach($choices as $choiceItem){
                        if($choiceItem->getId() != $choice->getId()){
                            $choiceItem->setVrai(false);
                            $this->entityManager->persist($choiceItem);
                        }
                    }
                 }
                 $choice->setStatut(Status::VALID);
                 $this->entityManager->persist($choice);
                 
                 $this->entityManager->flush();
                 $this->addFlash('success', $isEdit ? 'Choix modifié avec succès' :  'Choix ajouté avec succès');
                 return $this->redirectToRoute('coach_quiz_item_details', ['id'=> $item->getId()]);
             } catch(\Exception $e){
                 $this->addFlash('danger', $e->getMessage());
             }
         }
 
         return $this->render('formation/quiz/coach_add_quiz_item_choice.html.twig', [
             'form' => $form->createView(),
         ]);
    }
}