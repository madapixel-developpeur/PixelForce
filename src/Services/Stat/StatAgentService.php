<?php

namespace App\Services\Stat;

use DateTime;
use Exception;
use App\Entity\User;
use App\Entity\Secteur;
use App\Entity\TypeSecteur;
use App\Exception\CustomException;
use App\Repository\UserRepository;
use App\Services\User\AgentService;
use App\Services\RemunerationService;
use App\Services\ConfigSecteurService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Repository\RankHistoryRepository;
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
        private ConfigSecteurService $configSecteurService,
        private AgentService $agentService,
        private UserRepository $userRepository,
        private RankHistoryRepository $rankHistoryRepository,
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
        try {

            $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
            if (!trim($pbb_ws_url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $pbb_ws_url . '/api/pbb_summary?pbb_id=' . $pbb_id
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            return [
                "chiffreAffaire" => 0,
                "orders" => []
            ];
        }
    }

    public function getSummary($agentId, $secteurId)
    {
        if ($secteurId == $this->parameterBag->get('secteur_digital_id')) {
            return $this->getPbbSummary($agentId);
        } else {
            return [
                "chiffreAffaire" => 0,
                "orders" => []
            ];
        }
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

    public function getRemunerations($params)
    {
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url . '/api/remuneration/search',
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
        try {
            $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
            if (!trim($pbb_ws_url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $pbb_ws_url . '/api/pbb_stat/' . $pbb_id
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            return [
                "totalAmount" => 0,
                "orderCount" => 0
            ];
        }
    }


    public function getLPNAnnualAndMonthlyStat($identifier,DateTime $reference){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];

            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/agent-current-stat',
                [
                   'json' => array_merge( ['identifier' => $identifier], ['date_ref' =>  $reference->format('Y-m-d H:i:s')])
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            return [
                'ca_total_year' => 0,
                'remuneration_total_year' => 0,
                'ca_total_month' => 0,
                'remuneration_total_month' => 0,
            ];
        }
    }
    
    public function getPbbAnnualAndMonthlyStat($pbb_id,DateTime $reference)
    {
        try {
            $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
            if (!trim($pbb_ws_url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $pbb_ws_url . '/api/pbb-stat-annual-monthly',
                [
                   'json' => array_merge( ['user_id' => $pbb_id], ['date_ref' =>  $reference->format('Y-m-d H:i:s')])
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            return [
                "total_year" => 0,
                "total_month" => 0
            ];
        }
    }

    public function getCaStatLPN(string $identifier,DateTime $reference){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/agent-team-ca-stat',
                [
                   'json' => array_merge( ['identifier' => $identifier], ['date_ref' =>  $reference->format('Y-m-d H:i:s')])
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {

           throw $exception;
        }
    }


    public function getAgentCaStatEquipe($agent,$secteurId)
    {
        try {
            
            if ($secteurId == $this->parameterBag->get('secteur_digital_id')) {
                $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');

                $userData =  [
                    'id' => $agent->getId(),
                    'filleul' => $this->userRepository->getFilsJusqueNiveau($agent->getId(),$_ENV['LIMIT_NIVEAU_EQUIPE_LINEAIRE'],true)
                ];
                $response = $this->client->request(
                    'GET',
                    $pbb_ws_url . '/api/get-agent-ca-equipe-stat',
                    [
                        'json' => array_merge( ['user_data' => $userData], ['date' =>  (new DateTime())->format('Y-m-d H:i:s')])
                    ]
                );
                $content = json_decode($response->getContent(), true);
                return $content;
            }
            
            else if($secteurId == $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
                // $agentSecteur = $agent->getAgentSecteurById($secteurId);
                // $identifier = $agentSecteur->getSectorPlatformAccountId();
                // return  $this->getCaStatLPN($identifier, new DateTime());
                return [
                    "ca_perso" => 0,
                    "ca_equipe" => 0
                ];
            }else{
                throw new Exception();
            }
        } catch (\Exception $exception) {
            return [
                "ca_perso" => 0,
                "ca_equipe" => 0
            ];
        }
    }

    public function getAgentStatLittlePonailsNetwork($agent,$secteurId){
        try {
            
            if ($secteurId != $_ENV['SECTEUR_LITTLE_PONAILS_ID']){
                throw new CustomException('Secteur non prise en charge');
            }
            $agentSecteur = $agent->getAgentSecteurById($secteurId);
            $identifier = $agentSecteur->getSectorPlatformAccountId();
            return  $this->getCaStatLPN($identifier, new DateTime());
        } catch (\Exception $exception) {
            return [
                "ca_perso" => 0,
                "ca_equipe" => 0,
                "countTeam" => 0,
                'countDirectChildren' => 0
            ];
        }
    }

    public function getStat($agentId, $secteurId)
    {
        if ($secteurId == $this->parameterBag->get('secteur_digital_id')) {
            return $this->getPbbStat($agentId);
        } else {
            return [
                "totalAmount" => 0,
                "orderCount" => 0
            ];
        }
    }

    public function getGlobalStatLittlePonails($agentId, $secteurId,DateTime  $dateRef){
        if ($secteurId == $this->parameterBag->get('secteur_little_ponails_id')) {
            return $this->getLPNAnnualAndMonthlyStat($agentId,$dateRef);
        } else {
            return [
                'ca_total_year' => 0,
                'remuneration_total_year' => 0,
                'ca_total_month' => 0,
                'remuneration_total_month' => 0,
            ];
        }
    }

    public function getGlobalStat($agentId, $secteurId,DateTime  $dateRef)
    {
        if ($secteurId == $this->parameterBag->get('secteur_digital_id')) {
            return $this->getPbbAnnualAndMonthlyStat($agentId,$dateRef);
        } else {
            return [
                "total_year" => 0,
                "total_month" => 0
            ];
        }
    }

    public function getUserCurrentRank(User $user,DateTime $dateRef,Secteur $secteur){
        $rankInfo = $this->rankHistoryRepository->getUserCurrentRank($user,$dateRef,$secteur);
        if(!$rankInfo){
            return [
                'rank' => 1,
                'rankName' => "Apporteur d'affaire",
            ];
        }
        return [
            'rank' => $rankInfo->getUserRank(),
            'rankName' => $rankInfo->getRankName(),
        ];
    }

    public function getAgentStat(User $agent, Secteur $secteur)
    {
        $statDigital = null;
        $statFinance = null;
        $rankInfo = null;
        $statSecurite = null;
        $statLPN = null;
        if ($secteur->getId() == $this->parameterBag->get('secteur_finance_id')) {
            $statFinance = $this->getStatFinance($agent->getEmail());
        } elseif ( $secteur->getId() == $this->parameterBag->get('secteur_digital_id')) {
            // if ($secteur->getId() == $_ENV['SECTEUR_DIGITAL_ID']) {
            $statDigital = $this->getGlobalStat($agent->getId(), $secteur->getId(),new DateTime());
            $lastDayOfLastMonth = (new DateTime('first day of last month'))->modify('last day of this month');
            $rankInfo = $this->getUserCurrentRank($agent,$lastDayOfLastMonth,$secteur);
            // }
        } elseif ( $secteur->getId() == $this->parameterBag->get('secteur_securite_id')) { 
            $statSecurite = [
                'total_year' => 0,
                'total_month' => 0,
            ];
            $lastDayOfLastMonth = (new DateTime('first day of last month'))->modify('last day of this month');
            $rankInfo = $this->getUserCurrentRank($agent,$lastDayOfLastMonth,$secteur);
        } elseif ( $secteur->getId() == $this->parameterBag->get('secteur_little_ponails_id')) { 
            $agentSecteur = $agent->getAgentSecteurById($secteur?->getId());
            $statLPN = $this->getGlobalStatLittlePonails($agentSecteur->getSectorPlatformAccountId(), $secteur->getId(),new DateTime());
            $lastDayOfLastMonth = (new DateTime('first day of last month'))->modify('last day of this month');
            $rankInfo = $this->getUserCurrentRank($agent,$lastDayOfLastMonth,$secteur);
        }else{
            $statDigital = $this->getStat($agent->getId(), $secteur->getId());
        }

        $pbb_summary = $this->getSummary($agent->getId(), $secteur->getId());
        $statVente = $this->getStatVente($agent->getId(), $secteur->getId(), $secteur->getType()->getId());
        $chiffreAffaireTotal = $pbb_summary['chiffreAffaire'] + ($statVente != null ? $statVente['ca'] : 0);
        $nbVentesTotal = count($pbb_summary['orders']) + ($statVente != null ? $statVente['nbr_ventes'] : 0);
        $nbrRdv = $this->getNbrRdv($agent->getId());
        $soldeRemuneration = $this->userTransactionRepository->getSolde($agent, [$secteur->getId()]);
        $statRemuneration = $this->userTransactionRepository->getStatRemunerationAnnualMonthly($agent, [$secteur->getId()],new DateTime());
        return [
            'statDigital' => $statDigital,
            'statFinance' => $statFinance,
            'statSecurite' => $statSecurite,
            'nbrRdv' => $nbrRdv,
            'chiffreAffaireTotal' => $chiffreAffaireTotal,
            'soldeRemuneration' => $soldeRemuneration,
            'nbVentesTotal' => $nbVentesTotal,
            'statRemuneration' => $statRemuneration ,
            'rankInfo' => $rankInfo,
            'statLPN' => $statLPN,
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

    public function getStatFinance($email)
    {
        $result = ["customColumn" => 0, "referral_code_text" => null];
        try {
            $url = $this->parameterBag->get('finance_stat_url');
            // $email = 'elmannichi.m@gmail.com';
            if (!trim($url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $url,
                [
                    'query' => ['constraints' => json_encode([["key" => "_all", "constraint_type" => "equals", "value" => strtolower(trim($email))]])]
                ]
            );
            $content = json_decode($response->getContent(), true);
            if (count($content['response']['results']) > 0) {
                $result = array_merge($result, $content['response']['results'][0]);
            }
        } catch (\Exception $exception) {

        }
        return $result;
    }

    public function getInovaUserByRef($referral_code_text)
    {
        $result = null;
        try {
            $url = $this->parameterBag->get('finance_stat_url');
            if (!trim($url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $url,
                [
                    'query' => ['constraints' => json_encode([["key" => "referral_code_text", "constraint_type" => "equals", "value" => $referral_code_text]])]
                ]
            );
            $content = json_decode($response->getContent(), true);
            if (count($content['response']['results']) > 0) {
                $result = $content['response']['results'][0];
            }
        } catch (\Exception $exception) {

        }
        return $result;
    }

    public function getFinanceReferrals($referrer_code)
    {
        try {
            $url = $this->parameterBag->get('finance_stat_url');
            if (!trim($url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $url,
                [
                    'query' => ['constraints' => json_encode([["key" => "referrer_code_text", "constraint_type" => "equals", "value" => $referrer_code]])]
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content['response']['results'];
        } catch (\Exception $exception) {
            return [];
        }
    }

    public function getInovaUnilevelChildren(User $user, bool $currentLoggedUser = false)
    {
        $data = [];
        $data['ID'] = $user->getId();
        $data['name'] = $user->getNom() . ' ' . ($user->getPrenom() ?? '');
        $data['imageUrl'] = $this->agentService->getPic($user);
        $data['area'] = $user->getEmail();
        $data['office'] = in_array("ROLE_ADMIN", $user->getRoles()) ? "Admin" : "User";
        $data['isLoggedUser'] = $currentLoggedUser;
        $data['positionName'] = $user->getUsername();

        $userFinance = $this->getStatFinance($user->getEmail());

        if ($userFinance && $userFinance['referral_code_text']) {
            $children = $this->getFinanceReferrals($userFinance['referral_code_text']);
        } else {
            $children = [];
        }

        $i = 1;
        foreach ($children as $child) {
            $data['countChildren'] = count($children);
            $email = isset($child['authentication']) && $child['authentication'] && isset($child['authentication']['email']) && $child['authentication']['email'] && isset($child['authentication']['email']['email']) && $child['authentication']['email']['email'] ? $child['authentication']['email']['email'] : '';
            $data['children'][] = [
                'ID' => $i,
                'name' => isset($child['fullname_text']) && $child['fullname_text'] ? $child['fullname_text'] : '--',
                'imageUrl' => isset($child['photo_image']) && $child['photo_image'] ? $child['photo_image'] : null,
                'area' => $email,
                'office' => "User",
                'isLoggedUser' => false,
                'positionName' => $email
            ];
            $i++;
        }

        return $data;
    }

    public function getCaByIds($ids, DateTime $reference = new DateTime()){
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url . '/api/get-ca-array',
            [
                'json' => array_merge( ['ids' => $ids], ['date' =>  $reference->format('Y-m-d H:i:s')])
            ]
        );
        $result = json_decode($response->getContent(), true);
        return $result;
    }

    public function addSummaryCaToUnilevel($unilevel){
        if(!isset($unilevel['children']) && isset($unilevel['CA']) ) return $unilevel;
        $childrenIds = array_column($unilevel['children'] ?? [],'ID');
        if(!isset($unilevel['CA'])){
            $childrenIds[] = $unilevel['ID'];
        } 
        $childrenCaArray = $this->getCaByIds($childrenIds);



        if(isset($unilevel['children'])){
            foreach ($unilevel['children'] as &$children) {
                $item = array_filter($childrenCaArray, fn($item) => $item['id'] == $children['ID']);
                if(count($item) != 1){
                    $children['CA'] = number_format(0).'€';
                }
                else{
                    $children['CA'] = number_format(reset($item)['amount'],2).'€';
                }
                $children = $this->addSummaryCaToUnilevel($children);

            };
        }

        if(!isset($unilevel['CA'])) {
            $item = array_filter($childrenCaArray, fn($item) => $item['id'] == $unilevel['ID']);
            $unilevel['CA'] = (count($item) != 1) ? number_format(0).'€' : number_format(reset($item)['amount'],2).'€';
        }
        return $unilevel;
    }

    public function getCaHistory($parameters){
        try {
            $url = $this->parameterBag->get('pbb_ws_url');
            if (!trim($url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $url.'/api/get-ca-history',
                [
                    'query' => $parameters
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            return [];
        }
    }

    public function getNetWorkFromLittlePonails(string $identifier,DateTime $reference){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/mlm/network',
                [
                   'json' => array_merge( ['identifier' => $identifier], ['date_ref' =>  $reference->format('Y-m-d H:i:s')])
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
           throw $exception;
        }
    }

    public function reArrangeDataFromLpn($data){


        $reArrangedData['ID'] = $data['agent']['user']['id'];
        $reArrangedData['name'] = $data['agent']['user']['lastname'].' ' .$data['agent']['user']['firstnames'];
        $reArrangedData['imageUrl'] = '/assets/vuexy/images/portrait/small/avatar-s-11.jpg';
        $reArrangedData['area'] = $data['agent']['user']['email'];
        $reArrangedData['office'] =  "User";
        $reArrangedData['isLoggedUser'] = false;
        $reArrangedData['positionName'] = $data['agent']['username'];
        $reArrangedData['CA'] = number_format( $data['metadatas']['total_sales'],2).'€' ;
  
        $reArrangedData['countChildren'] = count($data['children'] );
        
        foreach ($data['children'] as $child) {
            $reArrangedData['children'][] = $this->reArrangeDataFromLpn($child);
        }   
        return $reArrangedData;
    }

    public function getLittlePonailsUnilevelChildren(User $user)
    {
        $agentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        if(!$agentSecteur){
            throw new CustomException('Secteur non prise en charge');
        }
        $identifier = $agentSecteur->getSectorPlatformAccountId();
        
        $networkFromLpn = $this->getNetWorkFromLittlePonails($identifier,new \DateTime);

        $data['ID'] = $networkFromLpn['currentUser']['id'];
        $data['name'] =  $networkFromLpn['currentUser']['name'];
        $data['imageUrl'] = '/assets/vuexy/images/portrait/small/avatar-s-11.jpg';
        $data['area'] =  $networkFromLpn['currentUser']['email'];
        $data['office'] =  "User";
        $data['isLoggedUser'] = false;
        $data['positionName'] =  $networkFromLpn['currentUser']['username'];
        $data['CA'] = number_format(  $networkFromLpn['currentUser']['CA'],2).'€' ;



        $data['countChildren'] = count($networkFromLpn["children"]);
        
        foreach ($networkFromLpn["children"] as $child) {
            $data['children'][] = $this->reArrangeDataFromLpn($child);
        } 

        return $data;
    }

    public function getOrderInfoFromLittlePonailsApi($identifier,$ref){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/mlm/order/view',
                [
                   'json' => ['identifier' => $identifier , 'ref' => $ref]
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            throw new CustomException("Une erreur s'est produite lors de la requête de donnée");
        }

     
    }


    public function getOrderDetailFromLittlePonails($user,$ref){
        $agentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        $identifier = $agentSecteur->getSectorPlatformAccountId();
        try {
            $data = $this->getOrderInfoFromLittlePonailsApi($identifier,$ref);
            return $data;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getOrdersFromLittlePonails(User $user,int $limit){
        $agentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        $identifier = $agentSecteur->getSectorPlatformAccountId();
        try {
            $data = $this->getOrdersFromLittlePonailsFromApi($identifier);
            return [
                'items' => $data['orders'],
                'itemNumberPerPage' => $data['count'],
                'total' => $data['count'],
                'currentPageNumber' => 1,
            ];
        } catch (\Exception $exception) {
            throw $exception;
            // return [
            //     'items' => [],
            //     'itemNumberPerPage' => 1,
            //     'total' => 0,
            //     'currentPageNumber' => 1,
            // ];
        }
    }

    public function getOrdersFromLittlePonailsFromApi($identifier){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/mlm/orders',
                [
                   'json' => ['identifier' => $identifier]
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            throw new CustomException("Une erreur s'est produite lors de la requête de donnée");
        }

     
    }

    public function getCaHistoryFromLittlePonailsFromApi($identifier,array $option = []){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/mlm/agent/ca_by_month',
                [
                   'json' => [
                        'identifier' => $identifier ,
                        'page' => $option['page'] ??'',
                        'limit' => $option['limit'] ?? ''  
                    ]
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            throw new CustomException("Une erreur s'est produite lors de la requête de donnée");
        }

    }


    public function getCaHistoryFromLittlePonails(User $user, int $page){
        $agentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        $identifier = $agentSecteur->getSectorPlatformAccountId();
        try {
            $data = $this->getCaHistoryFromLittlePonailsFromApi($identifier);
            return [
                'items' => $data['ca'],
                'itemNumberPerPage' => $data['count'],
                'total' => $data['count'],
                'currentPageNumber' => 1,
            ];
        } catch (\Exception $exception) {
            throw $exception;
        }
    }


    public function getCaHistoryDetailFromLittlePonailsApi($identifier,$month,$year){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/mlm/agent/ca_summary_by_month',
                [
                   'json' => [
                        'identifier' => $identifier ,
                        'month' => $month,
                        'year' => $year 
                    ]
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            throw new CustomException("Une erreur s'est produite lors de la requête de donnée");
        }
    }


    public function getCaHistoryDetailFromLittlePonails(User $user,$month,$year){
        $agentSecteur = $user->getAgentSecteurById($_ENV['SECTEUR_LITTLE_PONAILS_ID']);
        $identifier = $agentSecteur->getSectorPlatformAccountId();
        try {
            $data = $this->getCaHistoryDetailFromLittlePonailsApi($identifier,$month,$year);
            return $data;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
