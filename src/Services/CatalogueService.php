<?php


namespace App\Services;

use App\Exception\CustomException;
use Exception;
use App\Repository\ConfigRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CatalogueService
{
    public function __construct(private ParameterBagInterface $parameterBag, private HttpClientInterface $httpClient){}

    public function getServices($name)
    {
        $url = $_ENV['PBB_WS_URL'];
        $response = $this->httpClient->request(
            'GET',
            $url . "/api/services",
            [
                'query' => ['name' => $name]
            ]

        );
        $content = json_decode($response->getContent(), true) ;
        return $content;
    }

    public function getTypeContrats()
    {
        $url = $_ENV['PBB_WS_URL'];
        $response = $this->httpClient->request(
            'GET',
            $url . "/api/type-contrat",
            []

        );
        $content = json_decode($response->getContent(), true) ;
        return $content;
    }

     public function getTypePackages()
    {
        $url = $_ENV['PBB_WS_URL'];
        $response = $this->httpClient->request(
            'GET',
            $url . "/api/type-package",
            []

        );
        $content = json_decode($response->getContent(), true) ;
        return $content;
    }

    public function findPackage($id)
    {
        $url = $_ENV['PBB_WS_URL'];
        $response = $this->httpClient->request(
            'GET',
            $url . "/api/services/".$id,
            [
            ]

        );
        $content = json_decode($response->getContent(), true) ;
        return $content;
    }

    public function getPackageIntentSecret($id)
    {
        $url = $_ENV['PBB_WS_URL'];
        $response = $this->httpClient->request(
            'GET',
            $url . "/api/services/".$id."/intent-secret",
            [
            ]

        );
        $content = json_decode($response->getContent(), true) ;
        return $content;
    }


    
    public function getAllExistingServiceName()
    {
        $url = $_ENV['PBB_WS_URL'];
        $response = $this->httpClient->request(
            'GET',
            $url . "/api/all-existing-services-name",
            []

        );
        $content = json_decode($response->getContent(), true) ;
        return $content;
    }


  
}