<?php
namespace App\Services\Stat;

use App\Entity\TypeSecteur;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StatAgentService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, private HttpClientInterface $client,private ParameterBagInterface $parameterBag)
    {
        $this->entityManager = $entityManager;
    }

    public function getStatVente($agentId, $secteurId, $typeSecteurId){
        $conn = $this->entityManager->getConnection();


        $sql = '
            SELECT * FROM stat_vente_tout_agent 
            WHERE agent_id = :agentId AND secteur_id = :secteurId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId, 'secteurId' => $secteurId]);
        $result = (array)$resultSet->fetchAllAssociative();
        if(count($result) == 0) return null;
        return $result[0];
    }
    public function getPbbSummary($pbb_id){
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url.'/api/pbb_summary?pbb_id='.$pbb_id
        );
        $content = json_decode($response->getContent(), true);
        return $content;
    }
    public function getRevenuAnnee($annee, $secteurId = -1, $agentId = -1){
        $conn = $this->entityManager->getConnection();

        $sql = '
            call getRevenuAnneeAll(:agentId, :secteurId, :annee)
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId, 'secteurId' => $secteurId, 'annee' => $annee]);
        $result = (array)$resultSet->fetchAllAssociative();
        $total = array_sum(array_map(function($item) { 
            return $item['montant']; 
        }, $result));
        return ['result' => $result, 'total' => $total];
    }

    public function getRevenuAnneeMois($annee, $mois, $secteurId = -1, $agentId = -1){
        $conn = $this->entityManager->getConnection();

        $sql = '
            call getRevenuAnneeMois(:agentId, :secteurId, :annee, :mois)
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId, 'secteurId' => $secteurId, 'annee' => $annee, 'mois' => $mois]);
        $result = (array)$resultSet->fetchAllAssociative();
        if(count($result) == 0) return null;
        return $result[0];
    }

    public function getTopClients($agentId, $secteurId, $limit){
        $conn = $this->entityManager->getConnection();


        $sql = '
            SELECT * FROM client_secteur_agent 
            WHERE agent_id = :agentId AND secteur_id = :secteurId order by montant desc, nbr desc
             LIMIT %d 
            ';
        $sql = sprintf($sql, $limit);    
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId, 'secteurId' => $secteurId]);
        $result = $resultSet->fetchAllAssociative();
        return $result;
    }

    public function getNbrClients($agentId){
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT count(id) as nbr FROM active_clients 
            WHERE client_agent_id = :agentId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId]);
        $result = $resultSet->fetchNumeric();
        return $result[0];
    }

    public function getNbrRdv($userId){
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT count(id) as nbr FROM meeting 
            WHERE user_id = :userId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['userId' => $userId]);
        $result = $resultSet->fetchNumeric();
        return $result[0];
    }

    
}