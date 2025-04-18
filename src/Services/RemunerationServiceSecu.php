<?php

namespace App\Services;

use App\Entity\OrderSecu;
use DateTime;
use App\Entity\User;
use App\Entity\RankHistory;
use App\Entity\UserTransaction;
use App\Repository\UserRepository;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserTransactionRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RemunerationServiceSecu
{
    private $userTransactionRepository;
    private $userRepository;
    private $client;
    private $parameterBag;
    private $entityManager;

    public const BASE_COMMISSION = 0.25;

    public function __construct(
        UserTransactionRepository $userTransactionRepository,
        UserRepository $userRepository,
        HttpClientInterface $client,
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $entityManager,
        private SecteurRepository $secteurRepository
    ) {
        $this->userTransactionRepository = $userTransactionRepository;
        $this->userRepository = $userRepository;
        $this->client = $client;
        $this->parameterBag = $parameterBag;
        $this->entityManager = $entityManager;
    }

    public function getRemunerationAmount(OrderSecu $orderSecu)
    {
        return round((self::BASE_COMMISSION * $orderSecu->getMontantHt()), 2);
    }

    public function newOrder(OrderSecu $orderSecu)
    {
        try {
            $this->entityManager->beginTransaction();
            $remunerationAmount = $this->getRemunerationAmount($orderSecu);



            if ($remunerationAmount > 0) {
                $remuneration = new UserTransaction();
                $remuneration->setAmount($remunerationAmount);
                $remuneration->setUser($orderSecu->getAgent());
                $remuneration->setCreatedAt(new \DateTimeImmutable());
                $remuneration->setStatus(UserTransaction::STATUS_VALID);
                $remuneration->setSortie(false);
                $remuneration->setType(UserTransaction::TYPE_REMUNERATION);
                $remuneration->setSourceId($orderSecu->getId());
                $remuneration->setSecteur($orderSecu->getSecteur());
                $this->entityManager->persist($remuneration);
            }



            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $ex) {
            if ($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
        } finally {
            $this->entityManager->clear();
        }
    }

    public function getRemunerationAndSaveData($data, DateTime $dateOfTheMonthToCheck)
    {
        $pbb_ws_url = $this->parameterBag->get('pbb_ws_url');
        $response = $this->client->request(
            'POST',
            $pbb_ws_url . '/api/execute-remuneration-process',
            [
                'json' => array_merge(['users_data' => $data], ['date' => $dateOfTheMonthToCheck->format('Y-m-d H:i:s')])
            ]
        );
        $result = json_decode($response->getContent(), true);
        $secteurSecurite = $this->secteurRepository->find($_ENV['SECTEUR_SECURITE_ID']);
        $lastDayOfTheMonth = (clone $dateOfTheMonthToCheck)->modify('last day of this month');
        foreach ($result as $userData) {
            $user = $this->userRepository->find($userData['id']);
            if ($userData['amount'] > 0) {
                $remuneration = new UserTransaction();
                $remuneration->setAmount($userData['amount']);
                $remuneration->setUser($user);
                $remuneration->setCreatedAt(new \DateTimeImmutable());
                $remuneration->setStatus(UserTransaction::STATUS_VALID);
                $remuneration->setSortie(false);
                $remuneration->setType(UserTransaction::TYPE_REMUNERATION);
                $remuneration->setSecteur($secteurSecurite);
                $this->entityManager->persist($remuneration);
            }
            $rankHistory = new RankHistory();
            $rankHistory->setUserRank($userData['rank']);
            $rankHistory->setRankName($userData['rank_name']);
            $rankHistory->setUser($user);
            $rankHistory->setSecteur($secteurSecurite);
            $rankHistory->setCreatedAt($lastDayOfTheMonth);
            $this->entityManager->persist($rankHistory);
        }
        return true;
    }

    public function checkUserRemuneration(DateTime $dateOfTheMonthToCheck)
    {
        $users = $this->userRepository->findUserByRoleAndSecteur(User::ROLE_REVENDEUR, $_ENV['SECTEUR_SECURITE_ID']);
        $arrayWithFilleulData = [];
        $limitLevel = $_ENV['LIMIT_NIVEAU_EQUIPE_LINEAIRE'];
        foreach ($users as $user) {
            $arrayWithFilleulData[] = [
                'id' => $user->getId(),
                'filleul' => $this->userRepository->getFilsJusqueNiveau($user->getId(), $limitLevel, true)
            ];
        }
        $chunks = array_chunk($arrayWithFilleulData, 200);
        try {
            $this->entityManager->beginTransaction();
            foreach ($chunks as $chunk) {
                $this->getRemunerationAndSaveData($chunk, $dateOfTheMonthToCheck);
            }
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Exception $ex) {
            if ($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
        } finally {
            $this->entityManager->clear();
        }
    }
}
