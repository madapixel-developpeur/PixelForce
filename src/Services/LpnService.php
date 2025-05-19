<?php 

namespace App\Services;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;



class LpnService{

    public function __construct(
        private HttpClientInterface $client,
        private AuthService $authService,
        private SessionInterface $session,
        private TranslatorInterface $translator,
    ) {
        
    } 
    
    public function getBoxList()
    {
        $token=  $this->session->get('lpn_token');
        $LPN_BACK_URL = $_ENV['LITTLE_PONAILS_BACK_URL'];
        try{
            $response = $this->client->request(
                'GET',
                $LPN_BACK_URL . '/api/mlm/boxes',
                [
                    'headers' => ['Authorization' => 'Bearer ' . $token]
                    ,
                ]
            );
            $content = json_decode($response->getContent(), true);
            return $content;
        } catch (HttpExceptionInterface $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === Response::HTTP_UNAUTHORIZED ) {
                $content = json_decode($e->getResponse()->getContent(false), true);
                if($content['message'] == 'Expired JWT Token'){
                    $this->session->remove('lpn_token');
                    throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
                }
                throw new CustomException($content['message']);
            }
            if ($statusCode === 401) {
                $this->session->remove('lpn_token');
                throw new CustomException($this->translator->trans("Veuillez retaper votre mot de passe Little Ponails, s'il vous plaît."));
            }
            throw $e; 
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
}