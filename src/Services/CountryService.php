<?php
namespace App\Services;

use App\Entity\Contact;
use App\Entity\ContactInformation;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CountryService
{

    public function __construct(private ParameterBagInterface $parameterBag){}
    public function readJson()
    {
        // Define the file path (adjust as needed)
        $filePath = $this->parameterBag->get('kernel.project_dir') . '/public/data/countries.json';

        // Check if the file exists
        if (!file_exists($filePath)) {
            throw new \Exception('JSON file not found: ' . $filePath);
        }

        // Read the file contents
        $jsonContent = file_get_contents($filePath);

        // Decode the JSON (as an associative array)
        $data = json_decode($jsonContent, true);
        return $data;
    }
}