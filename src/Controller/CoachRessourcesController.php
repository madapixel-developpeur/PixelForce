<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Form\RessourceType;
use App\Repository\RessourceRepository;
use Google\Service\CloudControlsPartnerService\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Exception;
use Symfony\Component\Form\FormFactoryInterface;

class CoachRessourcesController extends AbstractController
{
    public function __construct(private RessourceRepository $ressourceRepository,private EntityManagerInterface $entityManager, private FormFactoryInterface $formFactoryInterface) {

    }

    #[Route('/coach/ressources', name: 'app_coach_ressources')]
    public function index(Request $request): Response
    {
        $id_parent = $request->query->getInt('id_parent', 0);
        $agent = $this->getUser();

        // Appeler la méthode findByAgentAndParent sans modifier le contrôleur
        $ressources = $this->ressourceRepository->findByAgentAndParent($agent, $id_parent > 0 ? $id_parent : null);

        return $this->render('coach_ressources/index.html.twig', [
            'controller_name' => 'CoachRessourcesController',
            'ressources' => $ressources,
            'id' => $id_parent
        ]);
    }

    #[Route('/coach/add_ressources', name: 'app_coach_add_ressources')]
    public function add_ressource(Request $request): Response
    {
        $isEdit = false;   
        $id_parent = $request->query->getInt('id_parent', 0);
        $ressource = new Ressource(); 
        $form = $this->formFactoryInterface->create(RessourceType::class, $ressource);

        if ($id_parent > 0) {
            $parentRessource = $this->entityManager->getRepository(Ressource::class)->find($id_parent);
            if ($parentRessource) {
                $ressource->setIdParent($parentRessource);
            }
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $this->getUser();
                $ressource->setAgent($user);

                if ($id_parent > 0) {
                    $parentRessource = $this->entityManager->getRepository(Ressource::class)->find($id_parent);
                    if ($parentRessource) {
                        
                        $parentRessource->setItem($parentRessource->getItem() + 1);
        
                        $this->entityManager->persist($parentRessource);
                    }
                }

                $this->entityManager->persist($ressource);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_coach_ressources', [
                    'id_parent' => $id_parent
                ]);
            } catch (\Exception $ex) {
                // Handle exceptions
                $error = $ex->getMessage();
            }
        }

        return $this->render('coach_ressources/form_dossier.html.twig', [
            'controller_name' => 'CoachRessourcesController',
            'form' => $form->createView(),
            'error' => $error ?? null,
            'isEdit' => $isEdit
        ]);
    }

    /**
     * @Route("/coach/edit_ressources/{id}", name="app_coach_edit_ressources")
     */
    public function edit(Request $request, Ressource $ressource): Response
    {
        $isEdit = true;
        $error = null;
        $id_parent = $request->query->getInt('id_parent', 0);
        $form = $this->createForm(RessourceType::class, $ressource);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $user = (object)$this->getUser();
                $ressource ->setAgent($user);
                $this->entityManager->persist($ressource);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_coach_ressources', [
                    'id_parent' => $id_parent
                ]);
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        }

        return $this->render('coach_ressources/form_dossier.html.twig', [
            'controller_name' => 'CoachRessourcesController',
            'form' => $form -> createView(),
            'error' => $error,
            'isEdit' => $isEdit
        ]);
    }

    /**
     * @Route("/coach/delete_ressources/{id}", name="app_coach_delete_ressources")
     */
    public function delete(Request $request, int $id): Response
    {
        try {
            // Trouver la ressource par ID
            $ressource = $this->entityManager->getRepository(Ressource::class)->find($id);

            if (!$ressource) {
                $this->addFlash('error', 'Ressource non trouvée');
                return $this->redirectToRoute('app_coach_ressources');
            }
            $idParent = $request->query->getInt('id_parent', 0);
            
            $parentRessource = $ressource->getIdParent();
            if ($parentRessource) {
                $parentRessource->setItem(max(0, $parentRessource->getItem() - 1));
                $this->entityManager->persist($parentRessource);
            }

            $this->entityManager->remove($ressource);
            $this->entityManager->flush();

            $this->addFlash('success', 'Ressource supprimée');
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $this->addFlash('error', $error);
        }

        return $this->redirectToRoute('app_coach_ressources', [
            'id_parent' => $idParent
        ]);
    }
}
