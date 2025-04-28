<?php

namespace App\Services;

use App\Entity\OrderSecu;
use App\Entity\RemunerationHistorySecu;
use App\Entity\Secteur;
use App\Model\RemunerationRequirementSecu;
use App\Repository\OrderSecuRepository;
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
        private SecteurRepository $secteurRepository,
        private OrderSecuRepository $orderSecuRepository
    ) {
        $this->userTransactionRepository = $userTransactionRepository;
        $this->userRepository = $userRepository;
        $this->client = $client;
        $this->parameterBag = $parameterBag;
        $this->entityManager = $entityManager;
    }

    public function getRemunerationAmount(OrderSecu $orderSecu)
    {
        return round((self::BASE_COMMISSION * $orderSecu->getAmountHt()), 2);
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

    public function getRemunerationAndSaveData($data, DateTime $dateOfTheMonthToCheck, $secteurId)
    {
        $result = $this->getRemunerationData($data, $dateOfTheMonthToCheck, $secteurId);
        $lastDayOfTheMonth = (clone $dateOfTheMonthToCheck)->modify('last day of this month');
        $secteurSecurite = $this->secteurRepository->find($secteurId);
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

    public function checkUserRemuneration(DateTime $dateOfTheMonthToCheck, $secteurId)
    {
        $users = $this->userRepository->findUserByRoleAndSecteur(User::ROLE_REVENDEUR, $secteurId);
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
                $this->getRemunerationAndSaveData($chunk, $dateOfTheMonthToCheck, $secteurId);
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

    public function getEquipeCaByLevel($userData, DateTime $start, DateTime $end, $secteurId)
    {
        $CA = [];
        foreach ($userData['filleul'] as $filleuls) {
            if (count($filleuls) == 0) {
                $CA[] = 0;
            } else {
                $CA[] = $this->orderSecuRepository->getCAMensuel($filleuls, $start, $end, $secteurId);
            }
        }
        return $CA;
    }

    public static function getQualificationArray()
    {
        $data = [];
        $data[] = new RemunerationRequirementSecu(1, "Apporteur d'affaire", 0, 0, [10, 5, 3], 0);
        $data[] = new RemunerationRequirementSecu(2, "Bronze", 3, 5000, [10, 5, 3], 250);
        $data[] = new RemunerationRequirementSecu(3, "Argent", 5, 15000, [12, 6, 4], 500);
        $data[] = new RemunerationRequirementSecu(4, "Or", 10, 30000, [15, 8, 5], 1000);
        $data[] = new RemunerationRequirementSecu(5, "Platine", 15, 50000, [18, 10, 6], 2500);
        $data[] = new RemunerationRequirementSecu(6, "Élite", 20, 100000, [20, 12, 7], 5000);
        return $data;
    }

    public function getStatutUser($userData, $equipeCA, $secteurId)
    {
        $directPartenaire = $userData['filleul'][0] ?? [];
        $actifPartenaire = count($directPartenaire) == 0 ? 0 : $this->orderSecuRepository->getActifPartenaire($directPartenaire, $secteurId);
        $totalEquipeCa = array_sum($equipeCA);
        $remunerationRequirementArray = self::getQualificationArray();
        $currentRequirement = $remunerationRequirementArray[0];
        ;
        foreach ($remunerationRequirementArray as $requirement) {
            if ($actifPartenaire < $requirement->getPartenaireActif() || $totalEquipeCa < $requirement->getCaEquipeMensuel()) {
                break;
            }
            $currentRequirement = $requirement;
        }
        return $currentRequirement;
    }

    public function getRemunerationData($usersDataArray, DateTime $dateReference, $secteurId)
    {
        $secteur = $this->secteurRepository->find($secteurId);
        $remunerationArray = [];
        $start = (clone $dateReference)->modify('first day of this month')->setTime(0, 0, 0);
        $end = (clone $dateReference)->modify('last day of this month')->setTime(23, 59, 59);
        try {
            $this->entityManager->getConnection()->beginTransaction();
            foreach ($usersDataArray as $userData) {
                $totalRemuneration = 0;
                $equipeCA = $this->getEquipeCaByLevel($userData, $start, $end, $secteur->getId());
                $remunerationRequirement = $this->getStatutUser($userData, $equipeCA, $secteur->getId());
                $remunerationEquipe = $remunerationRequirement->getRemunerationEquipe();
                foreach ($remunerationEquipe as $index => $item) {
                    $remunerationEquipe = round($equipeCA[$index] * $item / 100, 2);
                    if ($remunerationEquipe > 0) {
                        $totalRemuneration += $remunerationEquipe;
                        $history = new RemunerationHistorySecu();
                        $history->setAmount($remunerationEquipe);
                        $history->setDateReference($end);
                        $history->setUpdatedAt(new DateTime());
                        $history->setType(RemunerationHistorySecu::TYPE_REMUNERATION_EQUIPE);
                        $history->setLabel("Rémunération d'équipe - niveau " . ($index + 1));
                        $history->setIdAgent($userData['id']);
                        $history->setSecteur($secteur);
                        $this->entityManager->persist($history);
                    }
                }


                if ($remunerationRequirement->getBonusPalier() > 0) {
                    $totalRemuneration += $remunerationRequirement->getBonusPalier();
                    $history = new RemunerationHistorySecu();
                    $history->setAmount($remunerationRequirement->getBonusPalier());
                    $history->setDateReference($end);
                    $history->setUpdatedAt(new DateTime());
                    $history->setType(RemunerationHistorySecu::TYPE_BONUS_PALIER);
                    $history->setLabel("Bonus palier " . $remunerationRequirement->getNomStatut());
                    $history->setIdAgent($userData['id']);
                    $history->setSecteur($secteur);
                    $this->entityManager->persist($history);
                }
                $remunerationArray[] = [
                    'id' => $userData['id'],
                    'amount' => $totalRemuneration,
                    'rank' => $remunerationRequirement->getRang(),
                    'rank_name' => $remunerationRequirement->getNomStatut()
                ];
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
        return $remunerationArray;
    }

    public function getAgentCaStat($agentData, $secteurId, $start, $end, $withCaEquipe = true)
    {
        $totalEquipeCa = 0;
        if ($withCaEquipe) {
            $equipeCA = $this->getEquipeCaByLevel($agentData, $start, $end, $secteurId);
            $totalEquipeCa = array_sum($equipeCA);
        }
        $userCa = $this->orderSecuRepository->getStatBetween($agentData['id'], $secteurId, $start, $end)['totalAmount'];
        return [
            'ca_perso' => $userCa,
            'ca_equipe' => $totalEquipeCa,
        ];

    }

    public function getEquipeCaStat($userData, $secteurId, $dateReference, $withCaEquipe = true)
    {
        $dateReference = $dateReference ?? new DateTime();
        $start = (clone $dateReference)->modify('first day of this month')->setTime(0, 0, 0);
        $end = (clone $dateReference)->modify('last day of this month')->setTime(23, 59, 59);
        $caStat = $this->getAgentCaStat($userData, $secteurId, $start, $end, $withCaEquipe);
        return $caStat;
    }
}
