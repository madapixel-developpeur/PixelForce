<?php

namespace App\Services\User;

use App\Entity\User;
use App\Manager\EntityManager;
use App\Manager\StripeManager;
use App\Services\StripeService;
use App\Repository\UserRepository;
use App\Services\DirectoryManagement;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AgentService
{
    private $em;
    private $session;
    private $stripeService;
    private $stripeManager;

    public function __construct(EntityManager $em, SessionInterface $session, StripeService $stripeService, StripeManager $stripeManager,
        private  UserRepository $repoUser,
        private DirectoryManagement $directoryManagement,
        private UrlGeneratorInterface $urlGenerator
    )
    {
        $this->em = $em;
        $this->session = $session;
        $this->stripeService = $stripeService;
        $this->stripeManager = $stripeManager;
    }



    /**
     * Renvoie true si le status --- n'est pas --- UNPAID ou EXPIRED
     *
     * @param User $agent
     * @return boolean
     */
    public function isActivableContent(User $agent)
    {
        $accountStatus = $this->getAccountStatus($agent);
        $activable = '';

        if ($accountStatus === USER::ACCOUNT_STATUS['UNPAID'] || $accountStatus === USER::ACCOUNT_STATUS['EXPIRED'] ) {
            $activable = false;
        }else{
            $activable = true;
        }

        return $activable;
    }


    /**
     * Permet de gérer la session, pour savoir si quelques contenus de la page doivent être "activé" ou "désactivés"
     * 
     * La vérification du statut de compte est primordiale
     *
     * @param User $agent
     */
    public function setSesssionEnabledContent(User $agent)
    {
        if ($this->isActivableContent($agent) ) {
            $enableContent = $this->session->set('enabledContent', true);
        }else{
            $enableContent = $this->session->set('enabledContent', false);
        }

        return $enableContent;
    }



    /**
     * Permet de savoir le statut de compte
     *
     * NB : fonction capable de vérifier si le status est EXPIRED
     */
    public function getAccountStatus($agent)
    {
        $accountStatus = '';
        $accountStatus = ($this->isAccountExpired($agent)) ?  USER::ACCOUNT_STATUS['EXPIRED'] : $agent->getAccountStatus() ;
        if ($agent->getAccountStatus() === USER::ACCOUNT_STATUS['ACTIVE'] ) {
            $accountStatus = USER::ACCOUNT_STATUS['ACTIVE'] ;
        }

        return $accountStatus;
    }

    /**
     * return true si le compte de l'agent dépasse du 14 ème jours
     * @return boolean
     */
    public function isAccountExpired(User $agent)
    {
        if ($this->accountRemainingDate($agent) <= 0) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * Permet de savoir le jours restant pour le compte d'essaie
     */
    public function accountRemainingDate(User $agent)
    {
        if (is_null($agent->getAccountStartDate())) {
            // Si la accountStartDate est null, on défini $remainingDate en 1
            $remainingDate = 1;
        }else{
            $diff = $agent->getAccountStartDate()->diff(new \Datetime());
            $diffDays = $diff->days;
            $remainingDate =  USER::EXPIRY_DATE - $diffDays;
        }

        return $remainingDate;
    }

    
    /**
     * Permet d'enregistrer le premier utilisation du compte
     * @param User $agent
     */
    public function setStartDate(User $agent)
    {
        if (is_null( $agent->getAccountStartDate())) {
            $agent->setAccountStartDate(new \DateTime());
            return $this->em->save($agent);
        }
    }

    /**
     * Permet de créer un prix d'abonnement pour un compte Agent 
     */
    public function create_PlanAgentAccount($amount, $intervalUnit, $priceName, $planDescription)
    {
        $productName = 'Abonnement compte Agent';
        $productDescription = 'Un produit qui peut avoir plusieurs Price (Différents prix d\'abonnement)';
        $planParams = $this->stripeService->create_Subscription_ProductAndPrice($amount, $intervalUnit, $productName, $productDescription, $priceName, $planDescription);
        $this->stripeManager->persistCreationPlanAgentAccount($planParams);
    }


    public function getPic(User $user){
        $file = $this->directoryManagement->getMediaFolder_UserAvatars().DIRECTORY_SEPARATOR.$user->getPhoto();
        if(is_file($file)) {
            return $this->urlGenerator->generate('user_avatar', ['id' => $user->getId()]);
        }

        return '/assets/vuexy/images/portrait/small/avatar-s-11.jpg';
    }


    public function getUnilevelChildren(User $user,int $currentLevel,bool $currentLoggedUser = false, $limit=null){
        $data = [];
        $data['ID'] = $user->getId();
        $data['name'] = $user->getNom().' ' .($user->getPrenom()??'');
        $data['imageUrl'] = $this->getPic($user);
        $data['area'] = $user->getEmail();
        $data['office'] = in_array("ROLE_ADMIN", $user->getRoles()) ? "Admin" : "User";
        $data['isLoggedUser'] = $currentLoggedUser;
        $data['positionName'] = $user->getUsername();
        
        $limitEnv = $_ENV['LIMIT_NIVEAU_EQUIPE_LINEAIRE'];
        if(!($limit && $limit <= $limitEnv)) $limit = $limitEnv;
        
        $children = $this->repoUser->findBy(['parrain'=>$user->getId()]);
        if($currentLevel  <= $limit){
            foreach ($children as $child) {
                $data['countChildren'] = count($children);
                $data['children'][] = $this->getUnilevelChildren($child,$currentLevel+1,false,$limit);
            }   
         }
        return $data;
    }

    public function getNumberOfTeam(User $user,int $currentLevel){
        $equipe = 0;
        if($currentLevel  > $_ENV['LIMIT_NIVEAU_EQUIPE_LINEAIRE']) return 0;
        $children = $this->repoUser->findBy(['parrain'=>$user->getId()]);
        foreach ($children as $child) {
           $equipe +=  $this->getNumberOfTeam($child,$currentLevel+1)+1;
        }  
        return $equipe;

    }

}