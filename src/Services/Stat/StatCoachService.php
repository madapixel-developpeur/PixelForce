<?php
namespace App\Services\Stat;

use Exception;
use App\Entity\TypeSecteur;
use App\Exception\CustomException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

class StatCoachService
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        private HttpClientInterface $client
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getStatVente($secteurId){
        $conn = $this->entityManager->getConnection();


        $sql = '
            SELECT * FROM stat_vente_secteur 
            WHERE secteur_id = :secteurId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['secteurId' => $secteurId]);
        $result = (array)$resultSet->fetchAllAssociative();
        if(count($result) == 0) return null;
        return $result[0];
    }

    public function getAllStatVente()
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT * FROM stat_vente_secteur ORDER BY ca DESC
        ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = (array)$resultSet->fetchAllAssociative();

        return $result;
    }

    public function getBestStatVente(){
        $conn = $this->entityManager->getConnection();

        $sql = 'SELECT * FROM stat_vente_secteur WHERE ca = (SELECT MAX(ca) FROM stat_vente_secteur) LIMIT 1' ;
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = (array)$resultSet->fetchAllAssociative();

        return $result[0];
    }

    
    public function getNbrClients($secteurId){
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT count(client_id) as nbr FROM agent_secteur_client_valide 
            WHERE secteur_id = :secteurId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['secteurId' => $secteurId]);
        $result = $resultSet->fetchNumeric();
        return $result[0];
    }

    public function getNbrAgents($secteurId){
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT count(agent_id) as nbr FROM agent_secteur_valide 
            WHERE secteur_id = :secteurId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['secteurId' => $secteurId]);
        $result = $resultSet->fetchNumeric();
        return $result[0];
    }

    public function updateCataloguesWithData($data,$type){

        $url = [
            'package' => '/package/udpate', 
            'subservice' => '/package-subservice/udpate', 
            'packagePriceByContrat' => '/package-price-by-contrat/udpate'
        ];
        $updateSuffixUrl = $url[$type] ?? '';
        if(empty($updateSuffixUrl)){
            new CustomException("Contenu non prise en charge");
        };
        try {
            $BO_URL = $_ENV['PBB_WS_URL'];
            $response = $this->client->request(
                'POST',
                $BO_URL . '/api'.$updateSuffixUrl,
                [
                    'json' => $data, 
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
       } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }   
    }


     public function updatePackageStatus($data){
        try {
            $BO_URL = $_ENV['PBB_WS_URL'];
            $response = $this->client->request(
                'POST',
                $BO_URL . '/api/change-package-status',
                [
                    'json' => $data, 
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
       } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }   
    }

      public function deletePackageElement($data){
        try {
            $BO_URL = $_ENV['PBB_WS_URL'];
            $response = $this->client->request(
                'POST',
                $BO_URL . '/api/delete-package-element',
                [
                    'json' => $data, 
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
       } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 422 || $statusCode === 400) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                throw new CustomException($content['message']);
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }   
    }

    

    

    
}