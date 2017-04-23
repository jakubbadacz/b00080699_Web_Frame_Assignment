<?php
/**
 * Created by Jakub Badacz B00080699.
 * Date: 03/04/2017
 * Time: 15:10
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class AdminController
 * @package AppBundle\Controller
 *
 * @Route("/admin")
 */
class AdminController extends Controller{
    /**
     * @Route("/", name="admin_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin Page!</body></html>');
    }
}