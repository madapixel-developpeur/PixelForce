<?php
namespace App\Services\Stat;

use Exception;
use App\Entity\TypeSecteur;
use App\Entity\AgentCaTracking;
use App\Exception\CustomException;
use App\Repository\UserRepository;
use App\Repository\SecteurRepository;
use Symfony\Component\Intl\Countries;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Repository\AgentSecteurRepository;
use App\Repository\AgentCaTrackingRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StatAdminService
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private AgentSecteurRepository $agentSecteurRepository,
        private HttpClientInterface $client,
        private SecteurRepository $secteurRepository,
        private AgentCaTrackingRepository $agentCaTrackingRepository,
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getStatVente(){
        $conn = $this->entityManager->getConnection();
        $sql = 'SELECT * FROM stat_vente_admin';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = (array)$resultSet->fetchAllAssociative();
        if(count($result) == 0) return null;
        return $result[0];
    }

    public function getNbrCoachs(){
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT count(id) as nbr FROM active_coach 
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = $resultSet->fetchNumeric();
        return $result[0];
    }

    public function getNbrAgents(){
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT count(id) as nbr FROM active_agent 
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = $resultSet->fetchNumeric();
        return $result[0];
    }

    public function getNbrSecteurs(){
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT count(id) as nbr FROM secteur_active 
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = $resultSet->fetchNumeric();
        return $result[0];
    }

    public function getStatGeoAgentForGraph(){
        $data = $this->getStatGeoAgent();
        $max = max(array_values($data)); // 600
        foreach ($data as $country => $count) {
            $width = ($count / $max) * 100;
            $width = $count > 0 ? max(1, round($width)) : 0;
            $data[$country] = [
                'count' => $count ,
                'width' => $width ,
            ];
        }
        return $data;        
    }
    public function getStatGeoAgent(){
        $countAgentByCountry = $this->userRepository->getCountActiveAgentByCountry();
        $statData = [];
        foreach($countAgentByCountry  as $value){
            $countryCode = $value['country_code'] ?? '';
            if(Countries::exists($countryCode)){
                $countryName = Countries::getName($value['country_code'], 'fr'); 
            }elseif(empty($countryCode)){
                $countryName = 'Inconnu';    
            }else{
                $reCheckedCountryCode = $this->getCountryCodeFromName($countryCode);
                $countryName = ($reCheckedCountryCode) ? Countries::getName($reCheckedCountryCode, 'fr') : 'Inconnu';
            }
            $statData[$countryName] = ($statData[$countryName] ?? 0) + $value['total'];
        }
        arsort($statData);
        return $statData;
    }


    function getCountryCodeFromName(string $name): ?string {
        $nameLower = strtolower(trim($name));

        foreach (['en', 'fr'] as $locale) {
            $names = Countries::getNames($locale);
            foreach ($names as $code => $countryName) {
                if (strtolower($countryName) === $nameLower) {
                    return $code;
                }
            }
        }
        return null;
    }

    public function getStatAgentBySecteur(){
        $statSecteurAgents = $this->agentSecteurRepository->getStatAgentBySecteur();
        $countAgents = $this->userRepository->getCountActiveAgent();

        $statSecteurAgents = $this->secteurRepository->getStatValidSecteur();
        $statSecteurAgents = array_column($statSecteurAgents,'total','secteur');
        arsort($statSecteurAgents);
        foreach ($statSecteurAgents as $secteur => $count) {
            $width = ($count / $countAgents) * 100;
            $width = $count > 0 ? max(1, round($width)) : 0;
            $statSecteurAgents[$secteur] = [
                'count' => $count ,
                'width' => $width ,
            ];
        }
        return $statSecteurAgents;
    }

    public function getCaGlobalStat(){
        try {
            $url = $_ENV['PBB_WS_URL'];
            if (!trim($url))
                throw new \Exception('API unavailable');
            $response = $this->client->request(
                'GET',
                $url.'/api/pbb-global-stat',
                [
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            return [];
        }
    }

    public function getLpnGlobalStat(){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/mlm/global/ca_summary',
                [
                  
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            throw new CustomException("Une erreur s'est produite lors de la requête de donnée");
        }
    }

    public function getDigitalAgentStatCa(){
        try {
            $BO_URL = $_ENV['PBB_WS_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api/pbb-global-stat-agent',
                [
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            throw new CustomException("Une erreur s'est produite lors de la requête de donnée");
        }
    }

     public function getLpnAgentStatCa(){
        try {
            $BO_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
            if (!trim($BO_URL)){
                throw new \Exception('API unavailable');
            }
            $response = $this->client->request(
                'GET',
                $BO_URL . '/api-pxl/mlm/agent/ca-stat-ranking',
                [
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (\Exception $exception) {
            throw new CustomException("Une erreur s'est produite lors de la requête de donnée");
        }
    }

    public function transformIndexIntoFrenchMonth($data){
       $monthsFr = [
            1  => 'Jan',
            2  => 'Fév',
            3  => 'Mar',
            4  => 'Avr',
            5  => 'Mai',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Aoû',
            9  => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Déc',
        ];

        $monthlyBreakdownFr = [];

        foreach ($data as $monthNum => $value) {
            $monthName = $monthsFr[$monthNum];
            $monthlyBreakdownFr[$monthName] = $value;
        }
        return $monthlyBreakdownFr;
    }

    public function getGlobalCA(){
        $stat= [
            'overview' => [
                "total_year" => 0,
                "total_month" => 0,
                "total_cumul" => 0
            ],
            'monthly_breakdown' => []
        ];
        try {
            $digitalStat = $this->getCaGlobalStat();
            $lpnStat = $this->getLpnGlobalStat();
            $overview = [
                "total_year" => $digitalStat['overview']['total_year'] + $lpnStat['overview']['total_year'],
                "total_month" => $digitalStat['overview']['total_month'] + $lpnStat['overview']['total_month'],
                "total_cumul" => $digitalStat['overview']['total_cumul'] + $lpnStat['overview']['total_cumul'],
            ];

            $maxLength = max(count($digitalStat['monthly_breakdown']), count($lpnStat['monthly_breakdown']));
            $globalMonthlyBreakDown = [];

            for ($i = 1; $i <= $maxLength; $i++) {
                $digitalValue = $digitalStat['monthly_breakdown'][$i] ?? 0;
                $lpnValue = $lpnStat['monthly_breakdown'][$i] ?? 0;
                $globalMonthlyBreakDown[$i] = $digitalValue + $lpnValue;
            }

            return [
                'overview' => $overview,
                'monthly_breakdown' =>  $this->transformIndexIntoFrenchMonth($globalMonthlyBreakDown),
            ];
        } catch (\Throwable $th) {
            // dd($th);
            return  $stat;
        }
    }

    public function getStatGlobalBySecteur(){
        $secteurs = $this->secteurRepository->getValidSecteurs();
        $secteurCountAgent = $this->getStatAgentBySecteur();
        $stat = [];
        $monthlyBreakdown = [];
        foreach ($secteurs as $secteur) {
            $temp = [
                'secteur' => '' ,
                'count_agent' => 0,
                'total_month' => 0,
                'total_year' => 0,
                'total_cumul' => 0
            ];
            $temp['secteur'] = $secteur->getNom();
            $temp['count_agent'] = $secteurCountAgent[$secteur->getNom()]['count'] ?? 0;
            switch ($secteur->getId()) {
                case $_ENV['SECTEUR_DIGITAL_ID']:
                    $digitalStat = $this->getCaGlobalStat();
                    $temp['total_month'] = $digitalStat['overview']['total_month'];
                    $temp['total_year'] = $digitalStat['overview']['total_year'];
                    $temp['total_cumul'] = $digitalStat['overview']['total_cumul'];
                    $stat[] = $temp;
                    $monthlyBreakdown[$secteur->getNom()] = $this->transformIndexIntoFrenchMonth($digitalStat['monthly_breakdown']);
                    break;

                case $_ENV['SECTEUR_LITTLE_PONAILS_ID']:
                    $lpnStat = $this->getLpnGlobalStat();
                    $temp['total_month'] = $lpnStat['overview']['total_month'];
                    $temp['total_year'] = $lpnStat['overview']['total_year'];
                    $temp['total_cumul'] = $lpnStat['overview']['total_cumul'];
                    $monthlyBreakdown[$secteur->getNom()] = $this->transformIndexIntoFrenchMonth($lpnStat['monthly_breakdown']);
                    $stat[] = $temp;
                    break;
                default:
                    $stat[] = $temp;
                    break;
            }
        }
        usort($stat, function ($a, $b) {
            return $b['count_agent'] <=> $a['count_agent'];
        });

        return [
            'stat_secteur' => $stat,
            'monthly_breakdown' => $monthlyBreakdown
        ];

    }

    public function addRecordCaFromLpn(){
        $statCaLpn = $this->getLpnAgentStatCa();
        foreach ($statCaLpn as $key => $value) {
            # code...
            $agentSecteur =$this->agentSecteurRepository->findOneBy(['sectorPlatformAgentUsername' => $key]);
            if(!$agentSecteur) continue;
            $agentCaTracking = $this->agentCaTrackingRepository->findOneBy(['agent' => $agentSecteur->getAgent()]);
            if(!$agentCaTracking){
                $agentCaTracking = new AgentCaTracking();
                $agentCaTracking->setAgent($agentSecteur->getAgent());
            }
            $details = $agentCaTracking->getDetails()??[];
            $details['Little-Ponails'] = number_format($value, 2, ',', ' ')."€";
            $agentCaTracking->setDetails($details);
            $agentCaTracking->setAmount($agentCaTracking->getAmount() + $value);
            $this->entityManager->persist($agentCaTracking);
            $this->entityManager->flush();
        }
    }

    public function addRecordFromDigital(){
        $statCaDigital = $this->getDigitalAgentStatCa();
        foreach ($statCaDigital as $value) {
            $user = $this->userRepository->findOneBy(['id'=> $value['agent_id'] ]);
            if(!$user) continue;
            $agentCaTracking = $this->agentCaTrackingRepository->findOneBy(['agent' => $user]);
            if(!$agentCaTracking){
                $agentCaTracking = new AgentCaTracking();
                $agentCaTracking->setAgent($user);
            }
            $details = $agentCaTracking->getDetails()??[];
            $details['Digital'] = number_format($value['total'], 2, ',', ' ')."€";
            $agentCaTracking->setDetails($details);
            $agentCaTracking->setAmount($agentCaTracking->getAmount() + $value['total']);
            $this->entityManager->persist($agentCaTracking);
            $this->entityManager->flush();
        }
    }

    public function getRankingAgentByCa(){
        return $this->agentCaTrackingRepository->getRankingAgentByCa();
    }

    public function refreshCaTrackingTable(){
        $connection =  $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeStatement(
            $platform->getTruncateTableSQL('agent_ca_tracking', true)
        );
        try {
            $this->entityManager->beginTransaction();
            $this->addRecordCaFromLpn();
            $this->addRecordFromDigital();

            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (CustomException $th) {
            if ($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
        throw $th;
        } catch (\Throwable $th) {
            if ($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $th;
        }
    }


}