<?php


namespace App\Controller;


use Exception;
use App\Entity\User;
use App\Form\UserSearchType;
use App\Services\FileHandler;
use App\Util\Search\Constants;
use App\Entity\UserInformation;
use App\Exception\CustomException;
use App\Repository\UserRepository;
use App\Form\UserInformationFormType;
use App\Repository\SecteurRepository;
use App\Entity\SearchEntity\UserSearch;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CoachSecteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/professionnel/information")
 */
class ProfessionnelInformationController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        private EntityManagerInterface $entityManager,
        PaginatorInterface $paginator, 
        UserRepository $userRepository, 
        SessionInterface $session,
        private FileHandler $fileHandler
    )
    {

        $this->paginator = $paginator;
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/", name="professionnel_info")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        if($user->getProfesionnalInformationState() == User::INFORMATION_EMPTY){
            return $this->redirectToRoute('professionnel_add_info');     
        }
        return $this->render('user_category/professionnel/information/pro_information.html.twig', [
            'user' => $user,
            'userInformation' => $user->getInformation(),
        ]);
    }

      /**
     * @Route("/ajout", name="professionnel_add_info")
     */
    public function add(Request $request)
    {
        $user = $this->getUser();        
        $userInformation = $user->getInformation() ?? (new UserInformation())->setUser($user); 
        $form = $this->createForm(UserInformationFormType::class, $userInformation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $file = $form->get('portfolioFile')->getData();
                if(!$file  && empty($userInformation->getPortfolioLink())){
                    throw new CustomException('Veuillez fournir votre portfolio, sous forme de lien ou de fichier.');
                }
                if($file){
                    $filename = $this->fileHandler->upload($file, Constants::PORTFOLIO_FOLDER);
                    $userInformation->setPortfolioFile($filename);
                }
                $userInformation->setValidationDate(new \DateTime());
                $user->setProfesionnalInformationState(User::INFORMATION_PENDING);
                $user->setInformation($userInformation);
                $user->set($userInformation);
                $this->entityManager->flush();
                $this->addFlash('success',"Information enregistrée avec succès.");
                return $this->redirectToRoute('professionnel_info');    
            } catch(CustomException $ex){
                $error = $ex->getMessage();
                $this->addFlash('danger', $error);
            } catch(Exception $ex){
                $error = $ex->getMessage();
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }

        return $this->render('user_category/professionnel/information/pro_information_add.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/soumettre-a-nouveau", name="professionnel_resend_info")
     */
    public function resend(Request $request)
    {
        $user = $this->getUser();
        $user->setProfesionnalInformationState(User::INFORMATION_EMPTY);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('professionnel_add_info');    
    }

    /**
     * @Route("/download-portfolio/{id}", name="download_portfolio")
    */
    public function downloadPortfolio(UserInformation $userInformation)
    {
        // Path to your files directory
        $fileDirectory = $this->getParameter('kernel.project_dir') . '/public/files/';

        // Full path to the file
        $filePath = $fileDirectory . $userInformation->getPortfolioFile();

        // Check if the file exists
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('The file does not exist');
        }

        // Create a BinaryFileResponse
        $response = new BinaryFileResponse($filePath);

        // Optionally set a custom filename for the download
        $response->setContentDisposition(
            'attachment',
            $userInformation->getPortfolioFileName()
        );

        return $response;
    }
}
