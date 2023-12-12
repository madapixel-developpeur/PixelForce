<?php


namespace App\Controller\Anonymous;

use App\Form\AnonymousSignUpType;
use App\Services\SecurityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/anonymous/checkout")
 */
class AnonymousCheckoutController extends AbstractController
{

    public function __construct(private SecurityService $securityService)
    {
    }

    /**
     * @Route("/aroma/{token}", name="anonymous_aroma_checkout")
     */
    public function anonymous_aroma_checkout(string $token, Request $request)
    {
        // $anonymousForm = $this->createForm(AnonymousSignUpType::class);
        // $anonymousForm->handleRequest($request);
        // $error = null;
        // if ($anonymousForm->isSubmitted() && $anonymousForm->isValid()) {

        //     // Register the anonymous user
        //     $informations = [
        //         "email"=> $this->securityService->generateEmailForAnonymous()
        //     ];
        //     $user = $this->getUser() ?? $this->securityService->generateCredentialsForAnonymous($informations);
        //     !$this->getUser() && $this->securityService->autoAuthenticate($user);

        //     return $this->redirectToRoute("client_aroma_checkout_address", ["token"=>$token]);
        // }
        // return $this->render('user_category/client/aroma/cart/address.html.twig',[
        //     'form' => $anonymousForm->createView(),
        //     'token' => $token,
        //     'error' => $error
        // ]);
    }
}