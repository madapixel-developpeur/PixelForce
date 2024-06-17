<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\NewsLetters;
use App\Services\FileHandler;
use App\Manager\EntityManager;
use App\Form\NewsLettersFormType;
use App\Services\NewsLettersService;
use App\Entity\PiecesJointesNewsLetters;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NewsLettersRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\PieceJointeNewsLettersFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PiecesJointesNewsLettersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/news-letters")
 */
class AdminNewsLettersController extends AbstractController
{
    public function __construct(
        private EntityManager $entityManager,
        private NewsLettersService $newsLetterService,
        private FileHandler $fileHandler,
      
    ){

    }

    /**
     * @Route("/liste", name="admin_news_letters")
     */
    public function index(Request $request,PaginatorInterface $paginator,): Response
    {
        $page = $request->query->get('page', 1);
        $limit = 20;
        $query = $this->entityManager
        ->createQueryBuilder()
            ->select('nws')
            ->from(NewsLetters::class,'nws')
        ;  

        $emails = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('user_category/admin/news-letters/news_letters_list.html.twig', [
            'data' => $emails,
            // 'form' => $form->createView(),
        ]);
    }


      /**
     * @Route("/add", name="admin_news_letters_add")
     */
    public function add(Request $request)
    {
        $newsLetter = new NewsLetters();

        $form = $this->createForm(NewsLettersFormType::class, $newsLetter);
       
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->beginTransaction();
                $newsLetter->setCreatedAt(new DateTime());
                $this->entityManager->save($newsLetter);
                
                $files = $request->files->get('files');
                if ($files) {
                    foreach ($files as $file) {
                        $fichier_nom = $this->fileHandler->upload($file, "newsLetters/".$newsLetter->getId());
                        $pieceJointe = new PiecesJointesNewsLetters();
                        $pieceJointe->setNewsLetters($newsLetter);
                        $pieceJointe->setFilepath($fichier_nom);
                        $this->entityManager->save($pieceJointe);
                    }
                }
                $this->entityManager->flush();
                $this->entityManager->commit();
                $this->addFlash('success', "Newsletter enregistrée avec succès");
                return $this->redirectToRoute('admin_news_letters');
    
            }catch(\Exception $ex){
                $this->addFlash('success', "Une erreur s'est produite");
            }
                
        }

        return $this->render('user_category/admin/news-letters//add_news_letters.html.twig', [
            'form' => $form->createView(),
            'button' => 'Enregistrer',
            'btn_class' =>  'success',
        ]);    
    }

    /**
     * @Route("/envoyer/{id}", name="admin_send_news_letters", methods={"POST"})
     */
    public function sendNewsLetters(Request $request, NewsLetters $newsLetters): Response
    {
        try{
            $this->newsLetterService->proccessNewsLetters($newsLetters);
            $this->addFlash('success', "Newsletter en cours d'envoi "); 
        } catch(Exception $ex){
            $this->addFlash('danger',$ex->getMessage());
        }
        return $this->redirectToRoute('admin_news_letters');
    }
}
