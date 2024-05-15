<?php
namespace App\Services;

use App\Entity\UserTransaction;
use App\Repository\UserRepository;
use App\Repository\UserTransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RemunerationService
{
    private $userTransactionRepository;
    private $userRepository;
    private $client;
    private $parameterBag;
    private $entityManager;

    public const CONDITIONS = [
        ["type"=> "vente", "condition"=> "\$userVenteId == \$user->getId()", "gain" => "\$amount * 0.5 * 0.2"],
        ["type"=> "audit", "condition"=> "\$auditAgentId == \$user->getId()", "gain" => "\$amount * 0.5 * 0.1"],
        [
            "type"=> "position", 
            "position" => 1, 
            "condition"=> "\$user->getPosition() >= 1 || (count(\$filsNiveau[0]) >= 5 && \$caNiveau[0] >= 1000)", 
            "gain" => " \$niveau == 1 ? ((\$caNiveau[0] - \$amount) < 1000 && !(\$positionBefore >= 1) ? (\$amount - (1000 -  \$caNiveau[0])) : \$amount) * 0.5 * 0.1 : 0 "
        ],
        [
            "type"=> "position", 
            "position" => 2, 
            "condition"=> "\$user->getPosition() >= 2 || ((count(\$filsNiveau[0]) + count(\$filsNiveau[1]) + count(\$filsNiveau[2])) >= 25 )", 
            "gain" => "\$niveau == 2 ? \$amount * 0.5 * 0.1 : 0",
        ],
        [
            "type"=> "position", 
            "position" => 3, 
            "condition"=> "\$user->getPosition() >= 3 || ((count(\$filsNiveau[0]) + count(\$filsNiveau[1]) + count(\$filsNiveau[2])) >= 100 )", 
            "gain" => "(\$niveau == 1 ? ((\$caNiveau[0] - \$amount) < 1000 && !(\$positionBefore >= 1) ? (\$amount - (1000 -  \$caNiveau[0])) : \$amount) : \$amount  ) * 0.5 * 0.05 ",
        ],
    ];

    public function __construct(UserTransactionRepository $userTransactionRepository, UserRepository $userRepository,
    HttpClientInterface $client, ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager)
    {
        $this->userTransactionRepository = $userTransactionRepository;
        $this->userRepository = $userRepository;
        $this->client = $client;
        $this->parameterBag = $parameterBag;
        $this->entityManager = $entityManager;
    }

    public function newOrder($orderData){
        try{
            $this->entityManager->beginTransaction();
            $orderId = intval($orderData["id"]);
            $auditAgentId = intval($orderData["auditAgentId"]);
            $userVenteId = intval($orderData["userVenteId"]);
            $amount = floatval($orderData["amount"]);

            $auditAgent = $this->userRepository->find($auditAgentId);
            $userVente = $auditAgentId == $userVenteId ? $auditAgent : $this->userRepository->find($userVenteId);

            $usersCheck = [];
            $niveauLimit = 3;
            $currentUser = $auditAgent->getParrain();
            $currentNiveau = 1;
            while($currentNiveau <= $niveauLimit && $currentUser){
                $usersCheck[] = [
                    'user' => $currentUser,
                    'niveau' => $currentNiveau,
                ];
                $currentUser = $currentUser->getParrain();
            }
            
            $usersCheck[] = ['user' => $auditAgent];
            if($auditAgentId != $userVenteId){
                $usersCheck[] = ['user' => $userVente];
            }

            foreach($usersCheck as $dataCheck){
                $user = $dataCheck['user'];
                $positionBefore = $user->getPosition();
                $niveau = null;
                $filsNiveau = null;
                $caNiveau = null;
                if(isset($dataCheck['niveau'])){
                    $niveau = $dataCheck['niveau'];
                    $filsNiveau = $this->userRepository->getFilsJusqueNiveau($user, $niveauLimit);
                    $caNiveau = $this->getCa($filsNiveau);
                }

                $total = 0;
                foreach(self::CONDITIONS as $condition){
                    if($condition['type'] == 'position' && $niveau === null) break;
                    if(eval("return " . $condition['condition'] . ";")){
                        $total += floatval(eval("return " . $condition['gain'] . ";"));
                        if($condition['type'] == 'position' && $user->getPosition() < $condition['position']){
                            $user->setPosition($condition['position']);
                        }
                    } else if($condition['type'] == 'position'){
                        break;
                    }
                }

                if($total > 0){
                    $remuneration = new UserTransaction();
                    $remuneration->setAmount($total);
                    $remuneration->setUser($user);  
                    $remuneration->setCreatedAt(new \DateTimeImmutable());
                    $remuneration->setStatus(UserTransaction::STATUS_VALID);
                    $remuneration->setSortie(false);
                    $remuneration->setType(UserTransaction::TYPE_REMUNERATION);
                    $remuneration->setSourceId($orderId);
                    $this->entityManager->persist($remuneration);
                }

                $this->entityManager->persist($user);
                
            }
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch(\Exception $ex){
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
        }
        finally {
            $this->entityManager->clear();
        }
    }

    public function getCa($agentsTab){
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'GET',
            $pbb_ws_url.'/api/sum-amount',
            ['query' => ['agentIds' => join(';', array_map(function ($item){ return join(',', array_map(function ($subItem){ return join(',', $subItem->getId());}, $item));}, $agentsTab))]]
        );
        $content = json_decode($response->getContent(), true);
        return $content;
    }
}