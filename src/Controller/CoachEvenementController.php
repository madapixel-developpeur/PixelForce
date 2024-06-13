<?php

namespace App\Controller;

use DateTime;
use App\Entity\Evenement;
use App\Services\FileHandler;
use App\Manager\EntityManager;
use App\Form\EvenementFormType;
use App\Repository\EvenementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/coach/evenement')]
class CoachEvenementController extends AbstractController
{
    public function __construct(
        private FileHandler $fileHandler,
        private EvenementRepository $evenementRepository,
        private EntityManager $entityManager
    )
    {

    }

    #[Route('/', name: 'app_coach_evenement')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $query = $this->entityManager
            ->createQueryBuilder()
            ->select('e')
            ->from(Evenement::class, 'e')
            ->orderBy('e.createdAt','DESC')
        ;  
        $evenements = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );
        return $this->render('user_category/coach/evenement/list.html.twig', [
            'evenements' => $evenements,
            'filesDirectory' => $this->getParameter('files_directory_relative'),
        ]);
    }

    #[Route('/ajout', name: 'coach_add_evenement')]
    public function add(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementFormType::class, $evenement,[ 'isCreation' =>true]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setCoach($this->getUser());
            $evenement->setCreatedAt(new DateTime());
            $fichier = $form->get('filePath')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "evenement/");
                $evenement->setFilepath($fichier_nom);
            }
            $fichier = $form->get('couvertureFilePath')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "evenement/");
                $evenement->setCouvertureFilepath($fichier_nom);
            }
            $this->entityManager->save($evenement);
            $this->addFlash('success', "Nouvel évènement enregistré avec succès");
            return $this->redirectToRoute('app_coach_evenement');
        }
        return $this->render('user_category/coach/evenement/add_evenement.html.twig', [
            'form' => $form->createView(),
            'button' => 'Enregistrer',
            'btn_class' =>  'success',
        ]);    
    }

    #[Route('/detail/{id}', name: 'evenement_view')]
    public function view(Request $request,Evenement $evenement): Response
    {
        return $this->render('user_category/coach/evenement/view.html.twig', [
            'evenement' => $evenement,
            'filesDirectory' => $this->getParameter('files_directory_relative')
        ]);    
    }

    #[Route('/edit/{id}', name: 'coach_edit_evenement')]
    public function edit(Request $request,Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementFormType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setCoach($this->getUser());
            $fichier = $form->get('filePath')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "evenement/");
                $evenement->setFilepath($fichier_nom);
            }
            $fichier = $form->get('couvertureFilePath')->getData();
            if ($fichier) {
                $fichier_nom = $this->fileHandler->upload($fichier, "evenement/");
                $evenement->setCouvertureFilepath($fichier_nom);
            }
            $this->entityManager->save($evenement);
            $this->addFlash('success', "Evènement modifié avec succès");
            return $this->redirectToRoute('app_coach_evenement');
        }
        return $this->render('user_category/coach/evenement/add_evenement.html.twig', [
            'form' => $form->createView(),
            'button' => 'Modifier',
            'btn_class' =>  'success',
        ]);    
    }
}
