<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use App\Util\Status;
use App\DTO\PackageDTO;
use App\Entity\Ressource;
use App\DTO\PackageTypeDTO;
use App\Entity\Announcement;
use App\Form\PackageFormType;
use App\Services\FileHandler;
use App\Util\Search\Constants;
use App\Form\RessourceFormType;
use App\Services\SearchService;
use App\Form\RessourceFilterType;
use App\Exception\CustomException;
use App\Form\AnnouncementFormType;
use App\Services\CatalogueService;
use App\Form\AnnouncementFilterType;
use App\Util\Search\MyCriteriaParam;
use App\Services\Stat\StatCoachService;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PackagePriceByTypeContratType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\IsTrueValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/coach/catalogues-digitals')]
class CoachCatalogueController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private FileHandler $fileHandler,
        private TranslatorInterface $translator,
        private CatalogueService $catalogueService,
        private StatCoachService $statCoachService
    )
    {

    }

    
    

    #[Route('/', name: 'coach_service_digital_list')]
    public function index(Request $request): Response
    {
        $services = $this->catalogueService->getAllExistingServiceName();
        $services = array_column($services, 'service');
        return $this->render('user_category/coach/catalogues/digital/service_list.html.twig', [
            'result' => $services,
        ]);
    }

    #[Route('/packages/{service}', name: 'coach_package_digital_list')]
    public function listPckages(Request $request,$service = ''): Response
    {
        $packages = $this->catalogueService->getServices($service);
        return $this->render('user_category/coach/catalogues/digital/package_list.html.twig', [
            'packages' => $packages,
        ]);
    }

    #[Route('/editer-package/{id}', name: 'coach_edit_package_digital')]
    public function editPackage(Request $request,SerializerInterface $serializer,$id = -1): Response
    {
        $isEdit = false;
        if($id != -1){
            $isEdit = true;
            $package = $this->catalogueService->findPackage($id);
            $package['packageType'] = $serializer->denormalize($package['packageType'] , PackageTypeDTO::class);
        }else{
            $package = [];
        }
        $form = $this->createForm(PackageFormType::class, $package,[
            'isEdit' => $isEdit,
            'data_class' => null
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $data['packageType'] = ($data['packageType']?->getId()) ?? '';
                $this->statCoachService->updateCataloguesWithData($data,'package');
                $message = $isEdit ? 'Package modifié avec succès' : 'Package créé avec succès';
                $this->addFlash('success',$this->translator->trans($message));
                return $this->redirectToRoute('coach_edit_package_digital',['id' =>  $id] );
            }catch (CustomException $ex) {
                $this->addFlash('danger',$ex->getMessage());
            }catch (\Exception $ex) {
                // dd($ex);
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }
        
        return $this->render('user_category/coach/catalogues/digital/package_form.html.twig', [
            'form' => $form->createView(),
            'isEdit' => $isEdit,
        ]);
    }

    #[Route('/voir-package/{id}', name: 'coach_view_package_digital')]
    public function viewPackage(Request $request,$id): Response
    {
        $package = $this->catalogueService->findPackage($id);
        return $this->render('user_category/coach/catalogues/digital/package_view.html.twig', [
            'package' => $package,
        ]);
    }

    #[Route('/editer-package-subservice/{id}/{idsubservice}', name: 'coach_update_package_subservice_digital')]
    public function editPackageSubservice(Request $request,SerializerInterface $serializer,$id,$idsubservice = ''): Response
    {
        $isEdit = false;
        $package = $this->catalogueService->findPackage($id);
        $subservice = null;
        foreach ($package['packageSubservice'] as $value) {
            if($value['id'] == $idsubservice) $subservice = $value;
        }
        if($subservice) $isEdit = true;
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
                'label' => 'Nom du subservice',
                'data' => $subservice['name'] ?? ''
            ])
            ->add('content', TextareaType::class, [
                "label" => "Contenu",
                "trim" => true,
                "required" => false,
                'data' => $subservice['content'] ?? ''
            ])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $data['package'] = $id;
                $data['id'] = $idsubservice;
                $this->statCoachService->updateCataloguesWithData($data,'subservice');
                $message = $isEdit ? 'Package subservice modifié avec succès' : 'Package subservice créé avec succès';
                $this->addFlash('success',$this->translator->trans($message));
                return $this->redirectToRoute('coach_view_package_digital',['id' =>  $id] );
            }catch (CustomException $ex) {
                $this->addFlash('danger',$ex->getMessage());
            }catch (\Exception $ex) {
                // dd($ex);
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }
        return $this->render('user_category/coach/catalogues/digital/package_subservice_form.html.twig', [
            'form' => $form->createView(),
            'package' => $package,
            'isEdit' => $isEdit,
        ]);
    }

    #[Route('/editer-package-prix-contrat/{id}/{idPrixContrat}', name: 'coach_update_package_prix_contrat_digital')]
    public function editPackagePrixContrat(Request $request,SerializerInterface $serializer,$id,$idPrixContrat = ''): Response
    {
        $isEdit = false;
        $package = $this->catalogueService->findPackage($id);
        $prixContrat = [];
        foreach ($package['packagePriceByTypeContrats'] as $value) {
            if($value['id'] == $idPrixContrat){
                $isEdit = true;
                $prixContrat = $value;
                $prixContrat['typeContrat'] = $prixContrat['typeContrat']['id'] ?? '';
            }
        }
        if(!empty($prixContrat)) $isEdit = true;
        $form = $this->createForm(PackagePriceByTypeContratType::class, $prixContrat,[
            'isEdit' => $isEdit,
            'data_class' => null
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $form->getData();
                $data['package'] = $id;
                
                $this->statCoachService->updateCataloguesWithData($data,'packagePriceByContrat');
                $message = $isEdit ? 'Prix par type de contrat modifié avec succès' : 'Prix par type de contrat créé avec succès';
                $this->addFlash('success',$this->translator->trans($message));
                return $this->redirectToRoute('coach_view_package_digital',['id' =>  $id] );
            }catch (CustomException $ex) {
                $this->addFlash('danger',$ex->getMessage());
            }catch (\Exception $ex) {
                // dd($ex);
                $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
            }
        }
        return $this->render('user_category/coach/catalogues/digital/package_price_by_type_contrat_form.html.twig', [
            'form' => $form->createView(),
            'package' => $package,
            'isEdit' => $isEdit,
        ]);
    }


    
    #[Route('/changer-statut-package', name: 'app_coach_change_package_status', methods: ['POST'])]
    public function changePackageStatus(Request $request): Response
    {
        try {
            $data = [
                'id' => $request->request->get('id'),
                'new_status' => $request->request->get('new_status'),
            ];
            if(empty($data['id']) || empty($data['new_status'])){
                throw new CustomException('Information manquante');
            }
            $this->statCoachService->updatePackageStatus($data);
            $message ='Statut du package mise à jour avec succès';
            $this->addFlash('success',$this->translator->trans($message));
        }catch (CustomException $ex) {
            $this->addFlash('danger',$ex->getMessage());
        }catch (\Exception $ex) {
            // dd($ex);
            $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
        }
        return $this->redirectToRoute('coach_package_digital_list');

    }


    #[Route('/package-element-delete', name: 'app_coach_delete_package_element', methods: ['POST'])]
    public function deletePackageElement(Request $request): Response
    {
        try {
            $data = [
                'id' => $request->request->get('id'),
                'type' => $request->request->get('type'),
            ];
            if(empty($data['id'])|| empty($data['type'])){
                throw new CustomException('Information manquante');
            }
            $this->statCoachService->deletePackageElement($data);
            $message ='Statut du package mise à jour avec succès';
            $this->addFlash('success',$this->translator->trans($message));
        }catch (CustomException $ex) {
            $this->addFlash('danger',$ex->getMessage());
        }catch (\Exception $ex) {
            // dd($ex);
            $this->addFlash('danger', $_ENV['CUSTOM_ERROR_MESSAGE']);
        }
        return $this->redirectToRoute('coach_view_package_digital',['id'=>  $request->request->get('id-package') ]);

    }


  
    #[Route('/element-catalogues/{id}/delete', name: 'app_coach_delete_catalogues_element', methods: ['POST'])]
    public function delete($id): Response
    {
        try {
            // $this->entityManager->remove($announcement);
            // $this->entityManager->flush();
            // $this->addFlash('success', $this->translator->trans('Annonce supprimée avec succès'));
        } catch (\Exception $ex) {
            $this->addFlash('danger', $ex->getMessage());
        }
        return $this->redirectToRoute('app_coach_announcement_list');

    }

}