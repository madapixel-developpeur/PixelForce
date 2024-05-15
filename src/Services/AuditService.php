<?php
namespace App\Services;

use Exception;
use App\Entity\User;
use App\Entity\BasketItem;
use App\Manager\EntityManager;
use App\Repository\AuditRepository;
use DoctrineExtensions\Query\Sqlite\IfNull;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuditService
{
    private $session;
    private $entityManager;
    private $auditRepository;

    public function __construct(SessionInterface $session,EntityManager $manager,AuditRepository $auditRepository)
    {
        $this->session = $session;
        $this->entityManager = $manager;
        $this->auditRepository = $auditRepository;
    }
    public function findAudit(User $user){
        $role=$user->getRoles()[0];
        if($role==User::ROLE_AGENT){
            return $this->auditRepository->findBy(["propriétaire"=>$user]);
        }
        elseif($role==User::ROLE_COACH || $role==User::ROLE_AMBASSADEUR || $role==User::ROLE_ADMINISTRATEUR)
        {
            return $this->auditRepository->findAll();
        }
        else{
            return [];
        }
    }
   
}