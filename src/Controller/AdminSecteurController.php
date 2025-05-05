<?php


namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Entity\Secteur;
use App\Form\SecteurType;
use App\Services\PdfExport;
use App\Entity\CoachSecteur;
use App\Manager\UserManager;
use App\Services\FileHandler;
use App\Manager\EntityManager;
use App\Services\ExcelService;
use App\Form\SecteurSearchType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use App\Repository\SecteurRepository;
use App\Repository\CoachAgentRepository;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Entity\SearchEntity\SecteurSearch;
use App\Repository\CoachSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminSecteurController extends AbstractController
{
    protected $repoUser;
    protected $entityManager;
    protected $userManager;
    protected $repoCoachAgent;
    protected $repoSecteur;
    protected $repoCoachSecteur;
    private $fileHandler;

    public function __construct(
        UserRepository $repoUser,
        EntityManager $entityManager,
        UserManager $userManager,
        CoachAgentRepository $repoCoachAgent,
        SecteurRepository $repoSecteur,
        FileHandler $fileHandler,
        CoachSecteurRepository $repoCoachSecteur,
        private ExcelService $excelService,
        private PdfExport $pdfExport,
        private TranslatorInterface $translator

    )
    {
        $this->repoUser = $repoUser;
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
        $this->repoCoachAgent = $repoCoachAgent;
        $this->repoSecteur = $repoSecteur;
        $this->repoCoachSecteur = $repoCoachSecteur;
        $this->fileHandler = $fileHandler;
    }

    /**
     * @Route("/admin/secteur/liste", name="admin_sector_list")
     */
    public function admin_sector_list(Request $request, PaginatorInterface $paginator)
    {
        $action = $request->get('action_button');
        $secteurSearch = new SecteurSearch();
        $sectorFormSearch = $this->createForm(SecteurSearchType::class, $secteurSearch);
        $sectorFormSearch->handleRequest($request);

        if(!empty($action) && $action != 'search_action'){
            return $this->export( $this->repoSecteur->filter($secteurSearch)->getResult(),$action);
        }
        
        $sectors = $paginator->paginate(
            $this->repoSecteur->filter($secteurSearch),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user_category/admin/sector/list_sectors.html.twig', [
            'sectors' => $sectors,
            'repoCoachSecteur' => $this->repoCoachSecteur,
            'sectorSearchForm' => $sectorFormSearch->createView()
        ]);
    }

    /**
     * @Route("/admin/secteur/add", name="admin_sector_add")
     */
    public function admin_sector_add(Request $request)
    {
        $sector = new Secteur();
        $duplicateId = $request->get('duplicateId', null);
        if($duplicateId){
            $duplicateSecteur = $this->repoSecteur->find($duplicateId);
            $sector = $duplicateSecteur->duplicate();
        }
        
        // $coachSecteur = new CoachSecteur();
        $formSecteur = $this->createForm(SecteurType::class, $sector)
            // ->add('coach', EntityType::class, [
            //     'mapped' => false,
            //     'class' => User::class,
            //     'choice_label' => 'prenom',
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('u')
            //             ->where('u.roles LIKE :role')
            //             ->setParameter('role', '%'. User::ROLE_COACH.'%');
            //         ;
            //     }
            // ])
        ;

        $formSecteur->handleRequest($request);
        if ($formSecteur->isSubmitted() && $formSecteur->isValid()) {
            $imageCouverture = $formSecteur->get('couverture')->getData();
            if ($imageCouverture) {
                $photo = $this->fileHandler->upload($imageCouverture, "images\secteur\couverture");
                $sector->setCouverture($photo);
            }
            $affiche = $formSecteur->get('affiche')->getData();
            if ($affiche) {
                $photo = $this->fileHandler->upload($affiche, "images\secteur\affiche");
                $sector->setAffiche($photo);
            }
            $sector->setActive(1);
            $this->entityManager->save($sector);
            
            // $coachId = $request->request->get('secteur')['coach'];
            // $coach = $this->repoUser->find($coachId);
            // $coachSecteur->setCoach($coach);
            // $coachSecteur->setSecteur($sector);
            // $this->entityManager->save($coachSecteur);

            $this->addFlash('success', $this->translator->trans("Ajout d'un secteur avec succès"));
            return $this->redirectToRoute('admin_sector_list');    
        }

        return $this->render('user_category/admin/sector/add_sector.html.twig', [
            'formSecteur' => $formSecteur->createView()
        ]);    
    }


    /**
     * @Route("/admin/secteur/{id}/edit", name="admin_sector_edit")
     */
    public function admin_sector_edit(Request $request, Secteur $sector)
    {
        $formSecteur = $this->createForm(SecteurType::class, $sector);

        $formSecteur->handleRequest($request);
        if ($formSecteur->isSubmitted() && $formSecteur->isValid()) {
            $imageCouverture = $formSecteur->get('couverture')->getData();
            if ($imageCouverture) {
                $photo = $this->fileHandler->upload($imageCouverture, "images\secteur\couverture");
                $sector->setCouverture($photo);
            }
            $affiche = $formSecteur->get('affiche')->getData();
            if ($affiche) {
                $photo = $this->fileHandler->upload($affiche, "images\secteur\affiche");
                $sector->setAffiche($photo);
            }
            $this->entityManager->save($sector);
            $this->addFlash('success', $this->translator->trans("Modification secteur avec succès"));
            return $this->redirectToRoute('admin_sector_list');    
        }

        return $this->render('user_category/admin/sector/edit_sector.html.twig', [
            'formSecteur' => $formSecteur->createView(),
            'sector' => $sector
        ]);    
    }

    /**
     * @Route("/admin/secteur/{id}/delete", name="admin_sector_delete")
     */
    public function admin_sector_delete(Secteur $sector, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $sector->getId(), $request->get('_token'))) {
            $sector->setActive(-1);
            $this->entityManager->save($sector);

            $this->addFlash( 'danger', 'Secteur supprimé');
        }
        return $this->redirectToRoute('admin_sector_list');    
    }
    /**
     * @Route("/admin/secteur/{id}/reactiver", name="admin_sector_reactiver")
     */
    public function admin_sector_reactiver(Secteur $sector, Request $request)
    {  
            $sector->setActive(1);
            $this->entityManager->save($sector);

            $this->addFlash( 'success', $this->translator->trans('Secteur restauré'));
        return $this->redirectToRoute('admin_sector_list');    
    }

    public function export($data,$action): Response
    {
        
         try{
            $common_file_name = 'liste-secteurs';
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = ["Nom", "Description", "Type", "Etat"];
                $fields = [
                    "nom",
                    "description",
                    "secteurTypeName",
                    "activeStateStr",
                ];
                $file = $this->excelService->export($data, $fields, $headers);
    
                $name = $common_file_name."-$date.csv";

                return new BinaryFileResponse($file, 200, [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$name\"",
                ]);
            }
            elseif($action == 'excel'){
                $headers = ["Nom", "Description", "Type", "Etat"];
                $fields = [
                    "nom",
                    "description",
                    "secteurTypeName",
                    "activeStateStr",
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
                    ['name' =>"Nom", 'class' => "text-left"],
                    ['name' =>"Description"],
                    ['name' =>"Type"],
                    ['name' =>"Etat"]
                ];
                $fields = [
                    ['name' => "nom", 'class' => "text-left"],
                    ['name' => "description",'raw'=>true],
                    ['name' => "secteurTypeName"],
                    ['name' => "activeStateStr"],
                ];
                $pdf = $this->pdfExport->generateGenericPDF("Liste des secteurs",$data,$headers,$fields);

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
        return $this->redirectToRoute('admin_sector_list');

    }

}