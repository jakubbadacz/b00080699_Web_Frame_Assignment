<?php
/**
 * Created by Jakub Badacz B00080699.
 * Date: 03/04/2017
 * Time: 13:19
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Nurl;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Nurl controller
 *
 * @Route("/basket")
 */
class NurlBasketController extends Controller{

    /**
     * @Route("/", name="nurls_basket_index")
     */
    public function indexAction()
    {
        //no need to put electives array in Twig argument array - Twig
        //can get direct fata from session
        $argsArray = [];

        $templateName = 'basket/list';
        return $this->render($templateName. '.html.twig', $argsArray);
    }

    /**
     * @Route("/clear", name="nurls_basket_clear")
     */
    public function clearAction()
    {
        $session = new Session();
        $session->remove("basket");

        return $this->redirectToRoute('nurls_basket_index');
    }

    /**
     * @Route("/add/{id}", name="nurls_basket_add")
     */
    public function addToNurlCollection(Nurl $nurl)
    {
        //default = new empty array
        $nurls = [];

        //if no 'urls' array in the session, add an empty array
        $session = new Session();
        if($session->has("basket")){
            $nurls = $session->get("basket");
        }

        //get id of nurl
        $id = $nurl->getId();

        //only try to add to array if not already in the array
        if(!array_key_exists($id, $nurls)){
            //append $nurl to our list
            $nurls[$id] = $nurl;

            //store updated array back into the session
            $session->set("basket", $nurls);
        }

        return $this->redirectToRoute("nurls_basket_index");
    }

    /**
     * @Route("/delete/{id}", name="nurls_basket_delete")
     */
    public function deleteAction($id)
    {
        //default - new empty array
        $nurls = [];

        //if no 'nurls' array in the session, add an empty array
        $session = new Session();
        if($session->has("basket")){
            $nurls = $session->get("basket");
        }

        //only try to remove if it's in the array
        if(array_key_exists($id, $nurls)){
            //remove entry with $id
            unset($nurls[$id]);

            if(sizeof($nurls) < 1){
                return $this->redirectToRoute("nurls_basket_clear");
            }

            //store updated array back into the session
            $session->set("basket", $nurls);
        }

        return $this->redirectToRoute("nurls_basket_index");
    }
}