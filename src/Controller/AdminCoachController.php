<?php


namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Secteur;
use App\Form\SecteurType;
use App\Form\UserLoginType;
use App\Services\PdfExport;
use App\Entity\CoachSecteur;
use App\Form\UserSearchType;
use App\Manager\UserManager;
use App\Form\UserSecteurType;
use App\Form\AgentSecteurType;
use App\Form\CoachSecteurType;
use App\Manager\EntityManager;
use App\Services\ExcelService;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Repository\SecteurRepository;
use App\Services\AgentSecteurService;
use App\Entity\SearchEntity\UserSearch;
use App\Repository\CoachAgentRepository;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\CoachSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCoachController extends AbstractController
{
    protected $repoUser;
    protected $entityManager;
    protected $userManager;

    protected $repoCoachAgent;

    protected $repoSecteur;

    protected $repoCoachSecteur;

    public function __construct(
        UserRepository $repoUser,
        EntityManager $entityManager,
        UserManager $userManager,
        CoachAgentRepository $repoCoachAgent,
        SecteurRepository $repoSecteur,
        CoachSecteurRepository $repoCoachSecteur,
        private ExcelService $excelService,
        private PdfExport $pdfExport
    )
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->repoCoachAgent = $repoCoachAgent;
        $this->repoSecteur = $repoSecteur;
        $this->repoCoachSecteur = $repoCoachSecteur;
    }

    /**
     * @Route("/admin/coach/liste", name="admin_coach_list")
     */
    public function admin_coach_list(Request $request, PaginatorInterface $paginator)
    {
        $action = $request->get('action_button');
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)->remove('tag');
        $searchForm->handleRequest($request);
        // dd($this->repoUser->findCoachOrAgentQuery($search, User::ROLE_COACH));
        if(!empty($action) && $action != 'search_action'){
            return $this->export($this->repoUser->findCoachOrAgentQuery($search, User::ROLE_COACH),$action);
        }
        $coachs = $paginator->paginate(
            $this->repoUser->findCoachOrAgentQuery($search, User::ROLE_COACH),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/coach/list_coachs.html.twig', [
            'coachs' => $coachs,
            'searchForm' => $searchForm->createView(),
            'repoCoachSecteur' => $this->repoCoachSecteur
        ]);
    }

    /**
     * @Route("/admin/coach/{id}/view", name="admin_coach_view")
     */
    public function admin_coach_view(User $coach, AgentSecteurService $agentSecteurService)
    {
        $coachtSecteurs = $this->repoCoachSecteur->findBy(['coach' => $coach]);
        $secteurs = $agentSecteurService->getSecteurs($coachtSecteurs);

        return $this->render('user_category/admin/coach/view_coach.html.twig', [
            'coach' => $coach,
            'secteurs' => $secteurs,
            'coachtSecteurs' => $coachtSecteurs
        ]);
    }

    /**
     * @Route("/admin/coach/add", name="admin_coach_add")
     */
    public function admin_coach_add(Request $request)
    {
        $coach = new User();

        $formUser = $this->createForm(UserType::class, $coach)
            ->remove('photo')
            ->add('email')
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $coach->setRoles([USER::ROLE_COACH]);
            $coach->setPassword(base64_encode('_dfdkf12132_1321df'));
            
            $this->entityManager->save($coach);

            $this->addFlash('primary', "Information enregistrée avec succès, choisissez son secteur");
            return $this->redirectToRoute('admin_coach_secteur_relate', ['id' =>  $coach->getId()]);    
        }

        return $this->render('user_category/admin/coach/add_coach.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Suivant'
        ]);    
    }

    /**
     * @Route("/admin/coach/{id}/edit", name="admin_coach_edit")
     */
    public function admin_coach_edit(Request $request, User $coach)
    {
        $formUser = $this->createForm(UserType::class, $coach)
            ->remove('photo')
            ->add('email')
        ;
       
        $coachSecteur = $this->repoCoachSecteur->findBy(['coach' => $coach]);
        if ($coachSecteur) {
            $coachSecteur = $coachSecteur[0];
        }
       
        $formSecteur = $this->createForm(CoachSecteurType::class);

        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->entityManager->save($coach);
            $this->addFlash('success', "Modification du coach avec succès");
            return $this->redirectToRoute('admin_coach_list');    
        }

        return $this->render('user_category/admin/coach/edit_coach.html.twig', [
            'formUser' => $formUser->createView(),
            'coach' => $coach,
            'coachSecteur' => $coachSecteur,
            'formSecteur' => $formSecteur->createView()
        ]);    
    }

    /**
     * @Route("/admin/coach/{id}/secteur/relate", name="admin_coach_secteur_relate")
     */
    public function admin_coach_secteur_relate(Request $request, User $coach)
    {
        $coachSecteur = new CoachSecteur();
        $formCoachSecteur = $this->createFormBuilder($coachSecteur)
            ->add('secteur', EntityType::class, [
                'label'=> false,
                'class'=> Secteur::class,
                'choice_label' => 'nom'
            ])
            ->getForm()
        ;
        $formCoachSecteur->handleRequest($request);

        $button = 'Suivant';
        if ($request->query->get('edition') === 'attribution_only') {
            $button = 'Enregistrer';
        }
        
        if ($formCoachSecteur->isSubmitted() && $formCoachSecteur->isValid()) {
            $coachRelations = $this->repoCoachSecteur->findBy(['coach' => $coach]);
            if(count($coachRelations) > 0) {
                $this->entityManager->removeMultiple($coachRelations);
            }
            $secteurId = $request->request->get('form')['secteur'];
            $coach->setActive(true);
            $coachSecteur->setCoach($coach);
            $coachSecteur->setSecteur($this->repoSecteur->find($secteurId));
            $this->entityManager->save($coachSecteur);

            if ($request->query->get('edition') === 'attribution_only') {
                $this->addFlash('success', 'Secteur attribué avec succès');
                return $this->redirectToRoute('admin_coach_list');    
            }

            $this->addFlash('primary', "Secteur choisi avec succès");
            return $this->redirectToRoute('admin_coach_password_generate', ['id' => $coach->getId()]);    
        }
        return $this->render('user_category/admin/coach/relate_secteur.html.twig', [
            'formCoachSecteur' => $formCoachSecteur->createView(),
            'coach' => $coach,
            'button' => $button
        ]);
    }

    /**
     * @Route("/admin/coach/{id}/password/generate", name="admin_coach_password_generate")
     */
    public function admin_coach_password_generate(Request $request, User $coach)
    {
        $formUserPassword = $this->createForm(UserLoginType::class);
        $formUserPassword->handleRequest($request);
        if ($formUserPassword->isSubmitted() && $formUserPassword->isValid()) {
            $coach->setActive(true);
            $coach->setUsername($request->request->get('user_login')['username']);
            $this->userManager->setUserPasword($coach, $request->request->get('user_login')['password']['first'], '', false);
            $this->addFlash('success', 'Les informations sur le nouveau coach ont été bien enregistrées');
            return $this->redirectToRoute('admin_coach_list');    
        }


        return $this->render('user_category/admin/coach/generate_password_coach.html.twig', [
            'formUserPassword' => $formUserPassword->createView(),
            'button' => 'Enregistrer'
        ]);
    }


    /**
     * @Route("/admin/coach/{id}/delete", name="admin_coach_delete")
     */
    public function admin_coach_delete(User $coach, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $coach->getId(), $request->get('_token'))) {
           $coach->setActive(-1);
           $this->entityManager->save($coach);

            $this->addFlash('danger', 'Le coach a été banni du plateforme');
        }
        return $this->redirectToRoute('admin_coach_list');    
    }

    /**
     * @Route("/admin/coach/{id}/reactiver", name="admin_coach_reactiver")
     */
    public function admin_coach_reactiver(User $coach, Request $request)
    {

        $coach->setActive(1);
        $this->entityManager->save($coach);

        $this->addFlash('success', 'Le compte du coach a été réactivé');

        return $this->redirectToRoute('admin_coach_list');
    }
    
    
    /**
     * @Route("/admin/coach/secteur/{coachSecteur}/edit", name="admin_coach_secteur_edit")
     */
    public function admin_coach_secteur_edit(CoachSecteur $coachSecteur, Request $request)
    {
        $data = $_POST;

        $secteur = $this->repoSecteur->find($data["newSecteurId"]);
        
        // Si il n'y a pas de doublon, on sauvegarde la modification
        if ($request->getMethod() === "POST") {
            $coachSecteur->setSecteur($secteur);
            $this->entityManager->save($coachSecteur);

            return $this->json([
                'edit' => 'successfully',
                'newSector' => $secteur->getNom()
            ], 200);    
        }
    }  
    
    public function export($data,$action): Response
    {
        
         try{
            $common_file_name = 'liste-coachs';
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = ["Nom","Prénoms", "Email", "Téléphone", "Date d'inscription","Secteur"];
                $fields = [
                    "nom",
                    "prenom",
                    "email",
                    "telephone",
                    "createdAtStr",
                    "coachSecteursStr"
                ];
                $file = $this->excelService->export($data, $fields, $headers);
    
                $name = $common_file_name."-$date.csv";

                return new BinaryFileResponse($file, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$name\"",
                ]);
            }
            elseif($action == 'excel'){
                $headers = ["Nom","Prénoms", "Email", "Téléphone", "Date d'inscription","Secteur"];
                $fields = [
                    "nom",
                    "prenom",
                    "email",
                    "telephone",
                    "createdAtStr",
                    "coachSecteursStr"
                ];
                $spreadsheet = $this->excelService->exportXlsx($data, $fields, $headers);
        
             
                $name = $name = $common_file_name."-$date.xlsx";

                $writer = new Xlsx($spreadsheet);
            
                $response = new Response();
            
                // Set headers for the file download
                $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->headers->set('Content-Disposition', 'attachment;filename="' . $name . '"');
                $response->headers->set('Cache-Control', 'max-age=0'); // Ensure the file is not cached
            
                ob_start();
                $writer->save('php://output');
                $content = ob_get_clean();
                $response->setContent($content);
        
                return $response;
            
            }
            elseif($action == "pdf"){
                $headers = [
                    ['name' =>"Nom et prénoms", 'class' => "text-left"],
                    ['name' =>"Contact"],
                    ['name' =>"Date d'inscription"],
                    ['name' =>"Secteur"]
                ];
                $fields = [
                    ['name' => "fullName", 'class' => "text-left"],
                    ['name' => "fullContact",'raw'=>true, 'class' => "text-left"],
                    ['name' => "createdAtStr"],
                    ['name' => "coachSecteursStr"],
                ];
                $pdf = $this->pdfExport->generateGenericPDF("Liste des coachs",$data,$headers,$fields);

                $fileName = $common_file_name."-$date.pdf";
                $response = new Response($pdf);
                $response->headers->set('Content-Type', 'application/pdf');
                $response->headers->set('Content-Disposition', 'attachment; filename="'.$fileName.'"');
        
                return $response;

            }
        } 
        catch (Exception $ex) {
            $this->addFlash(
                'danger',
                $_ENV['CUSTOM_ERROR_MESSAGE']
            );
        }
        return $this->redirectToRoute('admin_coach_list');

    }
}
