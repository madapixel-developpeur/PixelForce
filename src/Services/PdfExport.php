<?php 

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;

class PdfExport{

    public function __construct(
        private string $projectDir,
        private Environment $twig,
        private ParameterBagInterface $params,
    ) {
        
    } 
    
    public function generateGenericPDF($title,$data,$headers,$fields)
    {
        $imagePath = $this->projectDir . '/public/assets/img/logo/pixelforce/logo-pixelforce-00.png';
        $file = new File($imagePath);

        // Vérifier si le fichier existe
        if ($file->isFile()) {
            // Convertir le contenu du fichier en base64
            $fileContent = base64_encode(file_get_contents($file->getPathname()));
        }

        $html = $this->twig->render('pdf/agent/generic_export.html.twig', [
            'title' => $title,
            'data' => $data,
            'fields' => $fields,
            'headers' => $headers,
            'img'=>$fileContent,
        ]);

        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf();


       
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}