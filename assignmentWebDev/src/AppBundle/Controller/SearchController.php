<?php
/**
 * Created by Jakub Badacz B00080699.
 * Date: 23/04/2017
 * Time: 23:09
 */

namespace AppBundle\Controller;


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{

    /**
     * @Route("/search", name="search_index")
     */
    public function searchAction(Request $request)
    {
        return $this->render('search/index.html.twig', array());
    }


    /**
     * @Route("/search/result", name="search_result")
     */
    public function resultsAction(Request $request)
    {
        $type = $request->request->get('type');
        $query = $request->request->get('query');
        
        $values = $this -> getvalues($type,$query);

        $argsArray = [
            'type' => $type,
            'values' => $values,
            'query' => $query
        ];


        return $this->render( 'search/result.html.twig', $argsArray);
    }


    public function getvalues($type,$query){

        $values = null;

        if($type == "User"){
            $values = $this -> getUsers($query);
        }

        elseif($type == "Nurl"){
            $values = $this -> getNurl($query);
        }
        elseif($type == "Collection"){

            $values = $this -> getCollection($query);
        }
        elseif($type == "Tag"){
            $values = $this -> getTag($query);
        }
        return $values;

    }

    private function getUsers($query)
    {
        $searched = array();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        if($query != null)

            foreach ($users as $user) {
                if (strpos($user -> getUsername(), $query) !== false) {
                    $searched[] = $user;
                }
            }
        return $searched;
    }

    private function getNurl($query)
    {
        $searched = array();
        $em = $this->getDoctrine()->getManager();
        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        if($query != null)
            foreach ($nurls as $nurl) {

                if (strpos($nurl -> getTitle(), $query) !== false) {
                    $searched[] = $nurl;
                }

            }

        return $searched;

    }

    private function getCollection($query)
    {
        $searched = array();
        $em = $this->getDoctrine()->getManager();
        $collections = $em->getRepository('AppBundle:Collection')->findAll();

        if($query != null)
            foreach ($collections as $collection) {
                if (strpos($collection -> getName(), $query) !== false) {
                    $searched[] = $collection;
                }
            }
        return $searched;
    }

    private function getTag($query)
    {

        $searched = array();
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        if($query != null)
            foreach ($tags as $tag) {
                if (strpos($tag -> getTagName(), $query) !== false) {
                    $searched[] = $tag;
                }
            }
        return $searched;
    }


}