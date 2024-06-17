<?php

namespace App\Controller;

use DateTime;
use Exception;
use App\Entity\NewsLetters;
use App\Manager\EntityManager;
use App\Form\NewsLettersFormType;
use App\Repository\NewsLettersRepository;
use App\Repository\PiecesJointesNewsLettersRepository;
use App\Services\NewsLettersService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/news-letters")
 */
class AdminNewsLettersController extends AbstractController
{
    public function __construct(
        private EntityManager $entityManager,
        private NewsLettersService $newsLetter,
      
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
            $newsLetter->setCreatedAt(new DateTime());
            $this->entityManager->save($newsLetter);
            $this->addFlash('success', "News letters enregistré avec succès");
            return $this->redirectToRoute('admin_news_letters');
        }

        return $this->render('user_category/admin/news-letters//add_news_letters.html.twig', [
            'form' => $form->createView(),
            'button' => 'Enregistrer',
            'btn_class' =>  'success',
        ]);    
    }
}
