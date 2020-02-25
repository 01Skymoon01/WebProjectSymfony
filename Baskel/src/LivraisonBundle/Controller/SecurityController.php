<?php


namespace LivraisonBundle\Controller;


use LivraisonBundle\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function loginAction(Request $request ,AuthenticationUtils $authenticationUtils)
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);


        $form->handleRequest($request);
        if ($form->isSubmitted() ) {

            var_dump($lastUsername);
            die();

            return $this->redirectToRoute('baskel_homepage');
        }
        return $this->render('@Livraison/Livreur/login_content.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}