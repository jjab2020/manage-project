<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $utils
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function login(AuthenticationUtils $utils):Response
    {
        if(!empty($this->getUser())) {
            return $this->redirectToRoute('project');
        }

        // get the login error if there is one
        $error = $utils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $utils->getLastUsername();


        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error'=>$error,
        ]);
    }


    /**
     * @route("login_success",name="login_success")
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function postLoginRedirectAction(Security $security)
    {
        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute("dashboard");
        }  else {
            return $this->redirectToRoute("home");
        }
    }

}