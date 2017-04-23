<?php
/**
 * Created by Jakub Badacz B00080699.
 * Date: 03/04/2017
 * Time: 14:20
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;


class SecurityController extends Controller{

    /**
     * login form
     *
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        //get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        //last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        //twig stuff
        $argsArray = [
            'last_username' => $lastUsername,
            'error' => $error,
        ];
        $templateName = 'security/login';

        return $this->render($templateName.".html.twig", $argsArray);
    }


}