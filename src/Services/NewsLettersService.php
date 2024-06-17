<?php
namespace App\Services;

use Exception;
use App\Entity\User;
use App\Entity\Audit;
use App\Entity\Prospect;
use App\Entity\BasketItem;
use App\Entity\NewsLetters;
use App\Manager\EntityManager;
use App\Util\Search\Constants;
use App\Repository\UserRepository;
use App\Repository\AuditRepository;
use App\Repository\ProspectRepository;
use App\Repository\NewsLettersRepository;
use DoctrineExtensions\Query\Sqlite\IfNull;
use App\Repository\PiecesJointesNewsLettersRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NewsLettersService
{


    public function __construct(private EntityManager $entityManager,
        private UserRepository $userRepository,
        private PiecesJointesNewsLettersRepository $piecesJointesNewsLettersRepository,
        private NewsLettersRepository $newsLettersRepository,
        private MailerService $mailerService,
        private ProspectRepository $prospectRepository
    )
    {

    }
    public function sendNewsLetters(){
        $newsLetter =  $this->newsLettersRepository->findOneBy(['state' => NewsLetters::PROCCESSING]);
        if(is_null($newsLetter)){
            return ; 
        }
        $piecesJointe =  $this->piecesJointesNewsLettersRepository->findBy(['newsLetters' => $newsLetter->getId()]);
        $emails = $this->userRepository->getListOfEmailsCombinedWithProspect(Constants::NUMBER_OF_MAIL_PER_OPERATION);
        if(count($emails) == 0){
            $newsLetter->setState(NewsLetters::SENT);
            $this->entityManager->save($newsLetter);
            return;
        }
        try {
            $this->entityManager->beginTransaction();

            foreach ($emails as $email) {
                $this->mailerService->sendNewsLetters($newsLetter,$piecesJointe,$email);
                $this->prospectRepository->changeStateNewsLettersByEmail($email,Prospect::NEWS_LETTERS_OK);
                $this->userRepository->changeStateNewsLettersByEmail($email,Prospect::NEWS_LETTERS_OK);
            }            
            $this->entityManager->flush();
            $this->entityManager->commit();
        }catch(\Exception $ex){
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            throw $ex;
            throw new Exception("Une erreur s'est produite");
        }
        finally {
            $this->entityManager->clear();
        }
    }

    public function proccessNewsLetters(NewsLetters $newsLetter){
        $item =  $this->newsLettersRepository->findOneBy(['state' => NewsLetters::PROCCESSING]);
        if($item){
            throw new Exception("Une newsletter est encore en cours d'envoi");
        }
        try {
            $this->entityManager->beginTransaction();

            $newsLetter->setState(NewsLetters::PROCCESSING);
            $this->userRepository->changeStateNewsLetters(User::NEWS_LETTERS_NEED_TO_SEND);
            $this->prospectRepository->changeStateNewsLetters(Prospect::NEWS_LETTERS_NEED_TO_SEND);

            $this->entityManager->flush();
            $this->entityManager->commit();

        }catch(\Exception $ex){
            if($this->entityManager->getConnection()->isTransactionActive()) {
                $this->entityManager->rollback();
            }
            // throw $ex;
            throw new Exception("Une erreur s'est produite");
        }
        finally {
            $this->entityManager->clear();
        }
    }
   
}