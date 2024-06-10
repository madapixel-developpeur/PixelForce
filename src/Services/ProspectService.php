<?php


namespace App\Services;

use Exception;
use App\Entity\Prospect;
use App\Services\Normalizer;
use App\Manager\EntityManager;
use App\Repository\UserRepository;
use App\Repository\ProspectRepository;

class ProspectService
{

    public function __construct(
        private  EntityManager $entityManager,
        private UserRepository $userRepository,
        private ProspectRepository $prospectRepository,
    )
    {        

    }


    public function checkExistingInfo($data){
        return $this->prospectRepository->checkExistingProspect($data);
    }

    public function saveProspectViaDataApi($data){
        $agent =$this->userRepository->findOneBy(['username' => $data['agent_username']]);
        if(is_null($agent)){
            throw new Exception('Le nom d\'utilisateur '.$data['agent_username'].' n\'existe pas.');
        }
        try {
            $prospect = new Prospect();
            $prospect->setAgent($agent);
            $prospect->setFirstname($data['nom']);
            $prospect->setLastname($data['prenom']);
            $prospect->setEmail($data['email']);
            $prospect->setPhone($data['telephone']);
            $prospect->setCreated_at(new \DateTime());

            if($data['platform']== Prospect::EUROPE_PLATFORM || $data['platform'] == Prospect::AFRICA_PLATFORM ){
                $prospect->setPlatform($data['platform']);
            }
            $this->entityManager->persist($prospect);
            $this->entityManager->flush();
        } catch (\Throwable $th) {
            throw new \Exception('Une erreur s\'est produite');
        }
      
    }

}