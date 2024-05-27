<?php


namespace App\Controller;

use App\Entity\Formation;
use App\Form\QuizFormType;
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
}