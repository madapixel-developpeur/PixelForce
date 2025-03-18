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
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAmbassadeurController extends AbstractController
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
     * @Route("/admin/ambassadeur/liste", name="admin_ambassadeur_list")
     */
    public function admin_ambassadeur_list(Request $request, PaginatorInterface $paginator)
    {
        $action = $request->get('action_button');
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)->remove('tag');
        $searchForm->handleRequest($request);
        // dd($this->repoUser->findCoachOrAgentQuery($search, User::ROLE_COACH));
        if(!empty($action) && $action != 'search_action'){
            return $this->export($this->repoUser->findCoachQuery($search, User::ROLE_AMBASSADEUR),$action);
        }
        $coachs = $paginator->paginate(
            $this->repoUser->findCoachQuery($search, User::ROLE_AMBASSADEUR),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/ambassadeur/list_ambassadeur.html.twig', [
            'coachs' => $coachs,
            'searchForm' => $searchForm->createView(),
            'repoCoachSecteur' => $this->repoCoachSecteur
        ]);
    }

    /**
     * @Route("/admin/ambassadeur/{id}/view", name="admin_ambassadeur_view")
     */
    public function admin_ambassadeur_view(User $ambassadeur,Request $request, AgentSecteurService $agentSecteurService, PaginatorInterface $paginator)
    {
        $coachtSecteurs = $this->repoCoachSecteur->findBy(['coach' => $ambassadeur]);
        $secteurs = $agentSecteurService->getSecteurs($coachtSecteurs);
        $result=$this->repoUser->findBy(['parrain'=>$ambassadeur->getId()]);
        $filleul = $paginator->paginate(
            $result,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('user_category/admin/ambassadeur/view_ambassadeur.html.twig', [
            'ambassadeur' => $ambassadeur,
            'secteurs' => $secteurs,
            'coachtSecteurs' => $coachtSecteurs,
            'filleul'=>$filleul
        ]);
    }

    /**
     * @Route("/admin/ambassadeur/add", name="admin_ambassadeur_add")
     */
    public function admin_ambassadeur_add(Request $request)
    {
        $coach = new User();

        $formUser = $this->createForm(UserType::class, $coach)
            ->remove('lienCalendly')
            ->remove('photo')
            ->add('email')
        ;
       
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $coach->setRoles([USER::ROLE_AMBASSADEUR]);
            $coach->setPassword(base64_encode('_dfdkf12132_1321df'));
            
            $this->entityManager->save($coach);

            $this->addFlash('primary', "Information enregistrée avec succès, choisissez son secteur");
            return $this->redirectToRoute('admin_ambassadeur_secteur_relate', ['id' =>  $coach->getId()]);    
        }

        return $this->render('user_category/admin/ambassadeur/add_ambassadeur.html.twig', [
            'formUser' => $formUser->createView(),
            'button' => 'Suivant'
        ]);    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/edit", name="admin_ambassadeur_edit")
     */
    public function admin_ambassadeur_edit(Request $request, User $ambassadeur)
    {
        $formUser = $this->createForm(UserType::class, $ambassadeur)
            ->remove('photo')
            ->add('email')
            ->remove('lienCalendly')
        ;
       
        $coachSecteur = $this->repoCoachSecteur->findBy(['coach' => $ambassadeur]);
        if ($coachSecteur) {
            $coachSecteur = $coachSecteur[0];
        }
       
        $formSecteur = $this->createForm(CoachSecteurType::class);

        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $this->entityManager->save($ambassadeur);
            $this->addFlash('success', "Modification du coach avec succès");
            return $this->redirectToRoute('admin_ambassadeur_list');    
        }

        return $this->render('user_category/admin/ambassadeur/edit_ambassadeur.html.twig', [
            'formUser' => $formUser->createView(),
            'coach' => $ambassadeur,
            'coachSecteur' => $coachSecteur,
            'formSecteur' => $formSecteur->createView()
        ]);    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/secteur/relate", name="admin_ambassadeur_secteur_relate")
     */
    public function admin_ambassadeur_secteur_relate(Request $request, User $ambassadeur)
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
            $coachRelations = $this->repoCoachSecteur->findBy(['coach' =>$ambassadeur]);
            if(count($coachRelations) > 0) {
                $this->entityManager->removeMultiple($coachRelations);
            }
            $secteurId = $request->request->get('form')['secteur'];
            $ambassadeur->setActive(true);
            $coachSecteur->setCoach($ambassadeur);
            $coachSecteur->setSecteur($this->repoSecteur->find($secteurId));
            $this->entityManager->save($coachSecteur);

            if ($request->query->get('edition') === 'attribution_only') {
                $this->addFlash('success', 'Secteur attribué avec succès');
                return $this->redirectToRoute('admin_ambassadeur_list');    
            }

            $this->addFlash('primary', "Secteur choisi avec succès");
            return $this->redirectToRoute('admin_ambassadeur_password_generate', ['id' => $ambassadeur->getId()]);    
        }
        return $this->render('user_category/admin/ambassadeur/relate_secteur.html.twig', [
            'formCoachSecteur' => $formCoachSecteur->createView(),
            'coach' => $ambassadeur,
            'button' => $button
        ]);
    }

    /**
     * @Route("/admin/ambassadeur/{id}/password/generate", name="admin_ambassadeur_password_generate")
     */
    public function admin_ambassadeur_password_generate(Request $request, User $ambassadeur)
    {
        $formUserPassword = $this->createForm(UserLoginType::class);
        $formUserPassword->handleRequest($request);
        if ($formUserPassword->isSubmitted() && $formUserPassword->isValid()) {
            $ambassadeur->setActive(true);
            $ambassadeur->setUsername($request->request->get('user_login')['username']);
            $this->userManager->setUserPasword($ambassadeur, $request->request->get('user_login')['password']['first'], '', false);
            $this->addFlash('success', 'Les informations sur le nouveau ambassadeur ont été bien enregistrées');
            return $this->redirectToRoute('admin_ambassadeur_list');    
        }


        return $this->render('user_category/admin/ambassadeur/generate_password_ambassadeur.html.twig', [
            'formUserPassword' => $formUserPassword->createView(),
            'button' => 'Enregistrer'
        ]);
    }


    /**
     * @Route("/admin/ambassadeur/{id}/delete", name="admin_ambassadeur_delete")
     */
    public function admin_ambassadeur_delete(User $ambassadeur, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $ambassadeur->getId(), $request->get('_token'))) {
            $ambassadeur->setActive(-1);
           $this->entityManager->save($ambassadeur);

            $this->addFlash('danger', 'L\'Ambassadeur a été banni du plateforme');
        }
        return $this->redirectToRoute('admin_ambassadeur_list');    
    }

    /**
     * @Route("/admin/ambassadeur/{id}/reactiver", name="admin_ambassadeur_reactiver")
     */
    public function admin_ambassadeur_reactiver(User $ambassadeur, Request $request)
    {

        $ambassadeur->setActive(1);
        $this->entityManager->save($ambassadeur);

        $this->addFlash('success', 'L\'Ambassadeur a été réactivé');

        return $this->redirectToRoute('admin_ambassadeur_list');
    }
    
    
    /**
     * @Route("/admin/ambassadeur/secteur/{coachSecteur}/edit", name="admin_coach_secteur_edit")
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
            $common_file_name = 'liste-ambassadeurs';
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = ["Nom et prénoms", "Username", "Email", "Téléphone","Date d'inscription","Nombre filleul","Secteur"];
                $fields = [
                    "fullName",
                    "username",
                    "email",
                    "telephone",
                    "createdAtStr",
                    "countFils",
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
                $headers = ["Nom et prénoms", "Username", "Email", "Téléphone","Date d'inscription","Nombre filleul","Secteur"];
                $fields = [
                    "fullName",
                    "username",
                    "email",
                    "telephone",
                    "createdAtStr",
                    "countFils",
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
                    ['name' => "Nom et prénoms",],
                    ['name' => "Username",],
                    ['name' => "Téléphone",],
                    ['name' => "Date d'inscription"],
                    ['name' => "Nombre filleul"],
                    ['name' => "Secteur",],
                ];
                
                $fields = [
                    ['name' => "fullName", 'class' => "text-left"],
                    ['name' => "username", 'class' => "text-left"],
                    ['name' => "fullContact",'class' => "text-left",'raw' => true],
                    ['name' => "createdAtStr"],
                    ['name' => "countFils","class" => "text-end"],
                    ['name' => "coachSecteursStr", 'class' => "text-left"],
                ];
                $pdf = $this->pdfExport->generateGenericPDF("Liste des Ambassadeurs",$data,$headers,$fields);

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
        return $this->redirectToRoute('admin_ambassadeur_list');

    }
}
