<?php


namespace App\Controller;


use App\Entity\Pack;
use App\Form\PackType;
use App\Manager\EntityManager;
use App\Repository\PackRepository;
use App\Services\FileHandler;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPackController extends AbstractController
{
    /**
     * @var PackRepository
     */
    private $packRepository;
    /**
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(private FileHandler $fileHandler, PackRepository $packRepository, PaginatorInterface $paginator, EntityManager $entityManager)
    {
        $this->packRepository = $packRepository;
        $this->paginator = $paginator;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/pack/list", name="admin_pack_list")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function admin_pack_list(Request $request)
    {
        $packs = $this->paginator->paginate(
            $this->packRepository->findAllActivePackQuery(),
            $request->query->get('page', 1),
            20
        );
        return $this->render('user_category/admin/pack/list.html.twig', [
            'packs' => $packs
        ]);
    }

    /**
     * @Route("/admin/pack/add", name="admin_pack_add")
     */
    public function admin_pack_add(Request $request)
    {
        $isEdit = true;
        $error = null;
        $pack = new Pack();
        $form = $this->createForm(PackType::class, $pack);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                // $imageFile = $form->get('imageFile')->getData();
                // if ($imageFile) {
                //     $photo = $this->fileHandler->upload($imageFile, "images\packs");
                //     $pack->setImage($photo);
                // }

                $documentFile = $form->get('documentFile')->getData();
                if ($documentFile) {
                    $file = $this->fileHandler->upload($documentFile, "documents\packs");
                    $pack->setDocument($file);
                }
                $pack->setStatus(1);
                $this->entityManager->save($pack);
                $this->addFlash('success', "Ajout d'un pack avec succès");
                return $this->redirectToRoute('admin_pack_list');
            } catch(\Exception $ex){
                $error = $ex->getMessage();
            }
        }

        return $this->render('user_category/admin/pack/add.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
            'isEdit' => $isEdit,
        ]);
    }


    /**
     * @Route("/admin/pack/edit/{id}", name="admin_pack_edit")
     */
    public function admin_pack_edit(Request $request, Pack $pack)
    {
        $isEdit = true;
        $error = null;
        $form = $this->createForm(PackType::class, $pack);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try{
                // $imageFile = $form->get('imageFile')->getData();
                // if ($imageFile) {
                //     $photo = $this->fileHandler->upload($imageFile, "images\packs");
                //     $pack->setImage($photo);
                // }

                $documentFile = $form->get('documentFile')->getData();
                if ($documentFile) {
                    $file = $this->fileHandler->upload($documentFile, "documents\productions");
                    $pack->setDocument($file);
                }
                $this->entityManager->save($pack);
                $this->addFlash('success', "Modification pack avec succès");
                return $this->redirectToRoute('admin_pack_list');
            } catch(\Exception $ex){
                $error = $ex->getMessage();
            }
        }

        return $this->render('user_category/admin/pack/edit.html.twig', [
            'form' => $form->createView(),
            'pack' => $pack,
            'error' => $error,
            'isEdit' => $isEdit,
        ]);
    }

    /**
     * @Route("/admin/pack/delete/{id}", name="admin_pack_delete")
     */
    public function admin_pack_delete(Pack $pack, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'. $pack->getId(), $request->get('_token'))) {
            $pack->setStatus(0);
            $this->entityManager->save($pack);
            $this->addFlash( 'danger', 'Pack supprimé');
        }
        return $this->redirectToRoute('admin_pack_list');
    }


}