<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Nurl;
use AppBundle\Entity\Tag;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormBuilder;

/**
 * Tag controller.
 *
 * @Route("tag")
 *
 */
class TagController extends Controller
{
    /**
     * Lists all tag entities.
     *
     * @Route("/", name="tag_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        return $this->render('tag/index.html.twig', array(
            'tags' => $tags,
        ));
    }

    /**
     * Creates a new tag entity.
     *
     * @Route("/new", name="tag_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $tag = new Tag();
        // Create a form
        $form = $this->createForm('AppBundle\Form\TagType', $tag);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //do this
            $tag -> setUser($this->get('security.token_storage')->getToken()->getUser());
            $tag ->setPending(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush($tag);

            return $this->redirectToRoute('tag_show', array('id' => $tag->getId()));
        }

        return $this->render('tag/new.html.twig', array(
            'tag' => $tag,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new proposed tag entity.
     *
     * @Route("/new/pending", name="tag_pending_new")
     * @Method({"GET", "POST"})
     */
    public function newPendingAction(Request $request)
    {

        $tag = new Tag();

        // Create a form
        $form = $this->createFormBuilder($tag)->add('tagName')->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //do this
            $tag -> setPending(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $em->flush($tag);

            return $this->redirectToRoute('tag_index', array('id' => $tag->getId()));
        }

        return $this->render('tag/new_pending.html.twig', array(
            'tag' => $tag,
            'form' => $form->createView(),
        ));
    }

    /**
     * Shows pending tags
     *
     * @Route("/pending", name="tag_pending")
     * @Method({"GET"})
     */
    public function pendingAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        return $this->render('tag/pending.html.twig', array(
            'tags' => $tags,
        ));
    }

    /**
     * Finds and displays a tag entity.
     *
     * @Route("/{id}", name="tag_show")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction(Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);

        return $this->render('tag/show.html.twig', array(
            'tag' => $tag,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tag entity.
     *
     * @Route("/{id}/edit", name="tag_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createForm('AppBundle\Form\TagType', $tag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tag_edit', array('id' => $tag->getId()));
        }

        return $this->render('tag/edit.html.twig', array(
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tag entity.
     *
     * @Route("/{id}/edit_pending", name="tag_edit_pending")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function editPendingAction(Request $request, Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createForm('AppBundle\Form\TagType', $tag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tag_edit', array('id' => $tag->getId()));
        }

        return $this->render('tag/edit_pending.html.twig', array(
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tag entity.
     *
     * @Route("/{id}", name="tag_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();
        }

        return $this->redirectToRoute('tag_index');
    }

    /**
     * Creates a form to delete a tag entity.
     *
     * @param Tag $tag The tag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', array('id' => $tag->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
