<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //create colors array
        $colors = [
            'foreground'=>'blue',
            'background'=>'pink',
        ];

        //store colors in session 'colors'
        $session = new Session();
        $session->set('colors', $colors);

        $argsArray = [
            'name' => 'jakub'
        ];

        $templateName = 'index';
        return $this->render($templateName . '.html.twig', $argsArray);
    }
}
