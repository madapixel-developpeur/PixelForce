<?php
namespace App\Services\Stat;

use App\Entity\TypeSecteur;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Exception;
class StatCoachService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
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

    

    
}