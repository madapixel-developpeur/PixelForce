<?php

namespace App\Services\Stat;

use App\Services\ConfigSecteurService;
use Exception;
use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\TypeSecteur;
use App\Services\RemunerationService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Repository\UserTransactionRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StatAgentService
{
    private $entityManager;
    private $remunerationService;

    public function __construct(
        EntityManagerInterface $entityManager,
        private HttpClientInterface $client,
        private ParameterBagInterface $parameterBag,
        RemunerationService $remunerationService,
        private UserTransactionRepository $userTransactionRepository,
        private ConfigSecteurService $configSecteurService
    ) {
        $this->entityManager = $entityManager;
        $this->remunerationService = $remunerationService;
    }

    public function getStatVente($agentId, $secteurId, $typeSecteurId)
    {
        $conn = $this->entityManager->getConnection();


        $sql = '
            SELECT * FROM stat_vente_tout_agent 
            WHERE agent_id = :agentId AND secteur_id = :secteurId
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId, 'secteurId' => $secteurId]);
        $result = (array) $resultSet->fetchAllAssociative();
        if (count($result) == 0)
            return null;
        return $result[0];
    }
    public function getPbbSummary($pbb_id)
    {
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url . '/api/pbb_summary?pbb_id=' . $pbb_id
        );
        $content = json_decode($response->getContent(), true);
        return $content;
    }
    public function getRevenuAnnee($annee, $secteurId = -1, $agentId = -1)
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
            call getRevenuAnneeAll(:agentId, :secteurId, :annee)
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId, 'secteurId' => $secteurId, 'annee' => $annee]);
        $result = (array) $resultSet->fetchAllAssociative();
        $total = array_sum(array_map(function ($item) {
            return $item['montant'];
        }, $result));
        return ['result' => $result, 'total' => $total];
    }

    public function getRevenuAnneeMois($annee, $mois, $secteurId = -1, $agentId = -1)
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
            call getRevenuAnneeMois(:agentId, :secteurId, :annee, :mois)
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['agentId' => $agentId, 'secteurId' => $secteurId, 'annee' => $annee, 'mois' => $mois]);
        $result = (array) $resultSet->fetchAllAssociative();
        if (count($result) == 0)
            return null;
        return $result[0];
    }

    public function getTopClients($agentId, $secteurId, $limit)
    {
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

    public function getNbrClients($agentId)
    {
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

    public function getNbrRdv($userId)
    {
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

    public function getOrders($params)
    {
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url . '/api/order/search',
            ['query' => $params]
        );
        $content = json_decode($response->getContent(), true);
        return $content;
    }

    public function getOrderById($id)
    {
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url . '/api/order/details/' . $id,
        );
        $content = json_decode($response->getContent(), true);
        return $content;
    }

    public function getPbbStat($pbb_id)
    {
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url . '/api/pbb_stat/' . $pbb_id
        );
        $content = json_decode($response->getContent(), true);
        return $content;
    }

    public function getAgentStat(User $agent, Secteur $secteur)
    {
        $statDigital = null;
        if ($secteur->getId() == $_ENV['SECTEUR_DIGITAL_ID']) {
            $statDigital = $this->getPbbStat($agent->getId());
        }
        $pbb_summary = $this->getPbbSummary($agent->getId(), $agent->getNom());
        $statVente = $this->getStatVente($agent->getId(), $secteur->getId(), $secteur->getType()->getId());
        $chiffreAffaireTotal = $pbb_summary['chiffreAffaire'] + ($statVente != null ? $statVente['ca'] : 0);
        $nbVentesTotal = count($pbb_summary['orders']) + ($statVente != null ? $statVente['nbr_ventes'] : 0);
        $nbrRdv = $this->getNbrRdv($agent->getId());
        $soldeRemuneration = $this->userTransactionRepository->getSolde($agent, [$secteur->getId()]);
        return [
            'statDigital' => $statDigital,
            'nbrRdv' => $nbrRdv,
            'chiffreAffaireTotal' => $chiffreAffaireTotal,
            'soldeRemuneration' => $soldeRemuneration,
            'nbVentesTotal' => $nbVentesTotal,
        ];
    }


    // public function progression()
    // {
    //     $reponse=[];
    //     $isCompletedBefore = true ;
    //     $positionSteps = $this->remunerationService.getPositionSteps() ;
    //     $length=count($positionSteps);
    //     $position=$this->getUser()->position;
    //      foreach($positionSteps as  $index => $step){
    //         isCompleted = ($index <= $app.user.position) ;
    //      } 

    //       isCurrent = (isCompletedBefore and not isCompleted) 
    //     <div class="step  if isCompleted  completed  endif   if isCurrent  current  endif ">
    //         <div class="step-icon-wrap">
    //         <div class="step-icon"> if isCompleted and not isLastStep <i class="fa fa-check"></i> else {{step.position}} endif </div>
    //         </div>
    //         <h4 class="step-title">{{step.label}}</h4>
    //     </div>
    //       isCompletedBefore = isCompleted 
    // }

    public function updateChatUserData($user, $data)
    {
        $chat_url = $this->parameterBag->get('base_url_chat');
        $response = $this->client->request(
            'PATCH',
            $chat_url . '/user/infos',
            [
                'headers' => [
                    'x-application' => 'pixelforce'
                ],
                'auth_bearer' => $this->configSecteurService->getUserJwtToken($user),
                'json' => ['data' => $data],
            ]
        );
        $content = json_decode($response->getContent(), true);
        return $content;
    }
}
