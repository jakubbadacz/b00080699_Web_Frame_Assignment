<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Nurl;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilder;


/**
 * Nurl controller.
 *
 * @Route("nurl")
 * @Security("has_role('ROLE_USER')")
 */
class NurlController extends Controller
{
    /**
     * Lists all nurl entities.
     *
     * @Route("/", name="nurl_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        $argsArray = [
            'nurls' => $nurls,
        ];

        $templateName = 'nurl/index';
        return $this->render($templateName.'.html.twig', $argsArray);
    }

    /**
     * Creates a new nurl entity.
     *
     * @Route("/new", name="nurl_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $nurl = new Nurl();

        $form = $this->createForm('AppBundle\Form\NurlType', $nurl);
        // Handle the form
        $nurl->setPending(false);
        $form->handleRequest($request);

        //If form is submitted with the above values
        if ($form->isSubmitted() && $form->isValid()) {
            $nurl -> setUser($this->get('security.token_storage')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($nurl);
            $em->flush($nurl);

            return $this->redirectToRoute('nurl_show', array('id' => $nurl->getId()));
        }
        return $this->render('nurl/new.html.twig', array(
            'nurl' => $nurl,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new proposed nurl entity.
     *
     * @Route("/new/pending", name="nurl_pending_new")
     * @Method({"GET", "POST"})
     */
    public function newPendingAction(Request $request)
    {

        $nurl = new Nurl();

        $form = $this->createForm('AppBundle\Form\NurlType', $nurl);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //do this
            $nurl -> setPending(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($nurl);
            $em->flush($nurl);

            return $this->redirectToRoute('nurl_index', array('id' => $nurl->getId()));
        }

        return $this->render('nurl/new_pending.html.twig', array(
            'nurl' => $nurl,
            'form' => $form->createView(),
        ));
    }

    /**
     * Shows pending nurls
     *
     * @Route("/pending", name="nurl_pending")
     * @Method({"GET"})
     */
    public function pendingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $nurls = $em->getRepository('AppBundle:Nurl')->findAll();

        return $this->render('nurl/pending.html.twig', array(
            'nurls' => $nurls,
        ));
    }

    /**
     * Finds and displays a nurl entity.
     *
     * @Route("/{id}", name="nurl_show")
     * @Method("GET")
     */
    public function showAction(Nurl $nurl)
    {
        $deleteForm = $this->createDeleteForm($nurl);

        return $this->render('nurl/show.html.twig', array(
            'nurl' => $nurl,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing nurl entity.
     *
     * @Route("/{id}/edit", name="nurl_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Nurl $nurl)
    {
        $deleteForm = $this->createDeleteForm($nurl);
        $editForm = $this->createForm('AppBundle\Form\NurlType', $nurl);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nurl_edit', array('id' => $nurl->getId()));
        }

        return $this->render('nurl/edit.html.twig', array(
            'nurl' => $nurl,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing nurl entity.
     *
     * @Route("/{id}/edit_pending", name="nurl_edit_pending")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function editPendingAction(Request $request, Nurl $nurl)
    {
        $deleteForm = $this->createDeleteForm($nurl);
        // Create a form
        $editForm = $this->createFormBuilder($nurl)->add('title', TextType::class)
            ->add('link', TextType::class)
            ->add('note', TextareaType::class)
            ->add('collection', EntityType::class, [
                'class' => 'AppBundle:Collection',
                'choice_label' => 'name',
            ])->add('tag', EntityType::class, [
                'class' => 'AppBundle:Tag',
                'choice_label' => 'tagName',
                'multiple' => true,
                'expanded' => true,
            ])->add('pending', ChoiceType::class, array(
                'choices' => array(
                    'Approve' => false,
                    'Pending' => true,
                ),
                'required' => true,
                'empty_data' => null
            ))->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nurl_edit', array('id' => $nurl->getId()));
        }

        return $this->render('nurl/edit_pending.html.twig', array(
            'nurl' => $nurl,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a nurl entity.
     *
     * @Route("/{id}", name="nurl_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Nurl $nurl)
    {
        $form = $this->createDeleteForm($nurl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nurl);
            $em->flush();
        }

        return $this->redirectToRoute('nurl_index');
    }

    /**
     * Creates a form to delete a nurl entity.
     *
     * @param Nurl $nurl The nurl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Nurl $nurl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nurl_delete', array('id' => $nurl->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

//    /**
//     * Creates a new nurl entity.
//     *
//     * @Route("/new", name="nurl_new")
//     * @Method({"GET", "POST"})
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
//     */
//    public function newAction(Request $request)
//    {
//        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
//        $nurl = new Nurl();
//        $collections = $repository = $this->getDoctrine()->getRepository('AppBundle:Collection')->findAll();
//
//        $form = $this->createFormBuilder($nurl)
//            ->add('url', TextType::class)
//            ->add('title', TextType::class)
//            ->add('content', TextareaType::class)
//            ->add('collection', EntityType::class, array(
//                // query choices from this entity
//                'class' => 'AppBundle:Collection',
//
//                // use the User.username property as the visible option string
//                'choice_label' => 'title',
//
//                // used to render a select box, check boxes or radios
//                'multiple' => false,
//                'expanded' => true,
//            ))
//
//            ->add('public', ChoiceType::class, array(
//                'choices' => array(
//                    'Public' => 'Public',
//                    'Private' => 'Private'
//                ),
//                'required' => true,
//                'empty_data' => null
//            ))
//
//            ->add('save', SubmitType::class, array('label' => 'Submit Nurl'))
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $nurl -> setUser($this->get('security.token_storage')->getToken()->getUser());
//            $nurl -> setUpvote(0);
//            $nurl -> setDownvote(0);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($nurl);
//            $em->flush($nurl);
//
//            return $this->redirectToRoute('nurl_show', array('id' => $nurl->getId()));
//        }
//
//        return $this->render('nurl/new.html.twig', array(
//            'nurl' => $nurl,
//            'form' => $form->createView(),
//        ));
//    }
}
