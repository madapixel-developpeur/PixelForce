<?php


namespace App\Services;

use App\Entity\Prospect;
use App\Services\Normalizer;
use App\Manager\EntityManager;
use App\Repository\UserRepository;

class ProspectService
{

    public function __construct(
        private  EntityManager $entityManager,
        private UserRepository $userRepository
    )
    {        

    }

    public function saveProspectViaDataApi($data){
        $agent = $this->userRepository->findOneBy(['username' => $data['agent_username']]);
        if(is_null($agent)){
            throw new \Exception("Nom d'utilisateur ".$data['agent_username']." introuvable");
        }
        try {
            $prospect = new Prospect();
            $prospect->setAgent($agent);
            $prospect->setFirstname($data['firstname']);
            $prospect->setLastname($data['lastname']);
            $prospect->setEmail($data['email']);
            $prospect->setPhone($data['numero']);
            $this->entityManager->persist($prospect);
            $this->entityManager->flush();
        } catch (\Throwable $th) {
            throw new \Exception("Une erreur s'est produite");
        }
      
    }

}