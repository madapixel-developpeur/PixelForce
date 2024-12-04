<?php
// src/Controller/FileUploadController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Services\FileHandler;

#[Route('/ressources')]
class RessourceController
{

    public function __construct(private FileHandler $fileHandler){}
    #[Route('/file/upload', name: 'app_ressource_file_upload', methods: ['POST'])]
    public function uploadFile(
        Request $request
    ): JsonResponse {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            return new JsonResponse(['message' => 'No file provided'], 400);
        }
        try{
            $filename = $this->fileHandler->upload($uploadedFile, "ressources");
            return new JsonResponse(['message' => 'File uploaded successfully', 'file' => $filename]);
        } catch(\Exception $ex){
            return new JsonResponse(['message' => $ex->getMessage()], 500);
        } 
    }

    #[Route('/file/download', name: 'app_ressource_file_download')]
    public function downloadFile(Request $request): Response
    {
        $filename = $request->get('filename');
        $response = new BinaryFileResponse(
            $this->getParameter('files_directory_relative')."/".
            $filename
        );
        // $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
        // $response->headers->set('Content-Type', 'appication/pdf');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            basename($filename)
        );
        return $response;
    }
}