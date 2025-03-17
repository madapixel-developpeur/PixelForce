<?php


namespace App\Controller;


use Exception;
use App\Entity\User;
use App\Services\PdfExport;
use App\Form\UserSearchType;
use App\Services\ExcelService;
use App\Repository\UserRepository;
use App\Repository\SecteurRepository;
use App\Entity\SearchEntity\UserSearch;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Repository\CoachSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Nucleos\DompdfBundle\Wrapper\DompdfWrapperInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AgentCoachController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var CoachSecteurRepository
     */
    private $coachSecteurRepository;
    /**
     * @var SecteurRepository
     */
    private $secteurRepository;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PaginatorInterface $paginator, UserRepository $userRepository, CoachSecteurRepository $coachSecteurRepository, SecteurRepository $secteurRepository, SessionInterface $session,
    private ExcelService $excelService,
    private DompdfWrapperInterface $wrapper,
    private PdfExport $pdfExport)
    {

        $this->paginator = $paginator;
        $this->coachSecteurRepository = $coachSecteurRepository;
        $this->secteurRepository = $secteurRepository;
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/agent/coach/list", name="agent_coach_list")
     */
    public function agent_coach_list(Request $request)
    {
        $action = $request->get('action_button');
        $secteur = $this->secteurRepository->findOneBy(['id' => $this->session->get('secteurId')]);
        $search = new UserSearch();
        $searchForm = $this->createForm(UserSearchType::class, $search)->remove('secteur')
            ->remove('tag')
            ->remove('dateInscriptionMin')
            ->remove('active')
            ->remove('dateInscriptionMax');
        $searchForm->handleRequest($request);
        if(!empty($action) && $action != 'search_action'){
            return $this->export(  $this->userRepository->findCoachBySecteur($search, $secteur, $request->get('search')),$action);
        }
        $agents = $this->paginator->paginate(
            $this->userRepository->findCoachBySecteur($search, $secteur, $request->get('search')),
            $request->query->getInt('page', 1),
            20
        );


        return $this->render('user_category/agent/coach/agent_coach_list.html.twig', [
            'coachs' => $agents,
            'searchForm' => $searchForm->createView(),
            'repoCoachSecteur' => $this->coachSecteurRepository,
            'mySector' => $secteur
        ]);
    }

    public function export($data,$action): Response
    {
        
         try{
            $common_file_name = 'liste-coach';
            $date = (new \DateTime())->format('Y-m-d m:s');
            if($action == "csv"){
                $headers = ["Nom et prénoms	", "Email", "Téléphone", "Secteur"];
                $fields = [
                    "fullName",
                    "email",
                    "telephone",
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
                $headers = ["Nom et prénoms	", "Email", "Téléphone", "Secteur"];
                $fields = [
                    "fullName",
                    "email",
                    "telephone",
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
                    ['name' =>"Email"],
                    ['name' =>"Téléphone"],
                    ['name' =>"Secteur"]
                ];
                $fields = [
                    ['name' => "fullName", 'class' => "text-left"],
                    ['name' => "email"],
                    ['name' => "telephone"],
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
        return $this->redirectToRoute('agent_coach_list');

    }
}
