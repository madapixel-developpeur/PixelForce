<?php
namespace App\Services;

use App\Entity\UserTransaction;
use App\Repository\SecteurRepository;
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
            "gain" => " \$niveau == 1 ? ((\$caNiveau[0] - \$amount) < 1000 && !(\$positionBefore >= 1) ? (\$caNiveau[0] - \$amount) : \$amount) * 0.5 * 0.1 : 0 "
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
            "gain" => "(\$niveau == 1 ? ((\$caNiveau[0] - \$amount) < 1000 && !(\$positionBefore >= 1) ? (\$caNiveau[0] - \$amount) : \$amount) : \$amount  ) * 0.5 * 0.05 ",
        ],
    ];

    public function __construct(UserTransactionRepository $userTransactionRepository, UserRepository $userRepository,
    HttpClientInterface $client, ParameterBagInterface $parameterBag, EntityManagerInterface $entityManager, 
        private SecteurRepository $secteurRepository)
    {
        $this->userTransactionRepository = $userTransactionRepository;
        $this->userRepository = $userRepository;
        $this->client = $client;
        $this->parameterBag = $parameterBag;
        $this->entityManager = $entityManager;
    }

    public function getFilsParrainNiveau($agentId, $niveauLimit=3){
        $agent = $this->userRepository->find(intval($agentId));
        $currentUser = $agent->getParrain();
        $result = [];
        $currentNiveau = 1;
        while($currentNiveau <= $niveauLimit && $currentUser){
            $result[] = [
                'userId' => $currentUser->getId(),
                'niveau' => $currentNiveau,
                'filsIdNiveau' => $this->userRepository->getFilsJusqueNiveau($currentUser->getId(), $niveauLimit, true),
            ];
            $currentUser = $currentUser->getParrain();
            $currentNiveau++;
        }
        return $result;
    }

    public function newOrder($orderData){
        try{
            $secteurId = $this->parameterBag->get('secteur_digital_id');
            $this->entityManager->beginTransaction();
            $orderId = intval($orderData['order']["id"]);
            $auditAgentId = intval($orderData['order']["auditAgentId"]);
            $userVenteId = intval($orderData['order']["userVenteId"]);
            $amount = floatval($orderData['order']["amount"]);

            $secteur = $this->secteurRepository->find($secteurId);
            $auditAgent = $this->userRepository->find($auditAgentId);
            $userVente = $auditAgentId == $userVenteId ? $auditAgent : $this->userRepository->find($userVenteId);

            $auditAgentIn = false;
            $venteUserIn = false;
            $usersCheck =  []; 
            foreach($orderData['filsParrainNiveau'] as $item){
                $item['user'] = $this->userRepository->find(intval($item['userId']));
                $item['niveau'] = intval($item['niveau']);
                if(!$auditAgentIn) $auditAgentIn = $auditAgent->getId() == $item['user']->getId();
                if(!$venteUserIn) $venteUserIn = $userVente->getId() == $item['user']->getId();
                $usersCheck[] = $item;
            }
            
            
            if(!$auditAgentIn){ 
                $usersCheck[] = ['user' => $auditAgent];
                if(!$venteUserIn) $venteUserIn = $userVente->getId() == $auditAgent->getId();
            }
            if(!$venteUserIn){
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
                    $filsNiveau = $dataCheck['filsIdNiveau'];
                    $caNiveau = array_map(function($item){return floatval($item); }, $dataCheck['caNiveau']);
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
                    $remuneration->setSecteur($secteur);
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

    public function getSoldeRemuneration($agent){

    }
}