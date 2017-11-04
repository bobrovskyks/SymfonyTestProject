<?php

namespace symfony\LibraryBundle\Controller;

use symfony\LibraryBundle\Entity\Library;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Library controller.
 *
 */
class LibraryController extends Controller
{
    /**
     * Lists all library entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $libraries = $em->getRepository('symfonyLibraryBundle:Library')->findAll();

        return $this->render('library/index.html.twig', array(
            'libraries' => $libraries,
        ));
    }

    /**
     * Creates a new library entity.
     *
     */
    public function newAction(Request $request)
    {
        $library = new Library();
        $form = $this->createForm('symfony\LibraryBundle\Form\LibraryType', $library);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($library);
            $em->flush();

            return $this->redirectToRoute('library_show', array('id' => $library->getId()));
        }

        return $this->render('library/new.html.twig', array(
            'library' => $library,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a library entity.
     *
     */
    public function showAction(Library $library)
    {
        $deleteForm = $this->createDeleteForm($library);

        return $this->render('library/show.html.twig', array(
            'library' => $library,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing library entity.
     *
     */
    public function editAction(Request $request, Library $library)
    {
        $deleteForm = $this->createDeleteForm($library);
        $editForm = $this->createForm('symfony\LibraryBundle\Form\LibraryType', $library);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('library_edit', array('id' => $library->getId()));
        }

        return $this->render('library/edit.html.twig', array(
            'library' => $library,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a library entity.
     *
     */
    public function deleteAction(Request $request, Library $library)
    {
        $form = $this->createDeleteForm($library);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($library);
            $em->flush();
        }

        return $this->redirectToRoute('library_index');
    }

    /**
     * Creates a form to delete a library entity.
     *
     * @param Library $library The library entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Library $library)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('library_delete', array('id' => $library->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
