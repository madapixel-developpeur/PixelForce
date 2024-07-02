<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception): Response
    {
        // Détermine le code d'état HTTP à partir de l'exception
        $code = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
        throw $exception;
        // Vous pouvez personnaliser les messages d'erreur en fonction du code d'état HTTP
        switch ($code) {
            case 401:
                $message = 'Utilisateur non authentifié';
                break;
            case 403:
                $message = 'Accès refusé';
                break;
            case 404:
                $message = 'Page non trouvée';
                break;
            case 500:
                $message = "Une erreur interne s'est produite sur le serveur.";
                break;
            case 502:
                $message = "Une erreur interne s'est produite sur le serveur.";
                break;
            case 503:
                $message = "Une erreur interne s'est produite sur le serveur.";
                break;
            case 504:
                $message = "Le serveur n'a pas répondu.";
                break;

            default:
                $message = "Une erreur interne s'est produite";
                break;
        }

        return $this->render('error/error.html.twig', [
            'code' => $code,
            'message' => $message,
        ]);
    }
}
