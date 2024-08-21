<?php


namespace App\Controller\Chat;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/myapi")
 */
class MyApiController extends AbstractController
{

    /**
     * @Route("/login", name="myapi_login", methods={"POST"})
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // Handle authentication logic...
    }
}