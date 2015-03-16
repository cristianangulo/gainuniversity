<?php

namespace Elearn\ElearnBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elearn\ElearnBundle\Entity\ComentariosItems;
use Elearn\ElearnBundle\Form\ComentariosItemsType;

/**
 * ComentariosItems controller.
 *
 */
class ComentariosItemsController extends Controller
{

    /**
     * Lists all ComentariosItems entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ElearnBundle:ComentariosItems')->findAll();

        return $this->render('ElearnBundle:ComentariosItems:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ComentariosItems entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ComentariosItems();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comentarios_items_show', array('id' => $entity->getId())));
        }

        return $this->render('ElearnBundle:ComentariosItems:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ComentariosItems entity.
     *
     * @param ComentariosItems $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ComentariosItems $entity)
    {
        $form = $this->createForm(new ComentariosItemsType(), $entity, array(
            'action' => $this->generateUrl('comentarios_items_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ComentariosItems entity.
     *
     */
    public function newAction()
    {
        $entity = new ComentariosItems();
        $form   = $this->createCreateForm($entity);

        return $this->render('ElearnBundle:ComentariosItems:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ComentariosItems entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:ComentariosItems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComentariosItems entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:ComentariosItems:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ComentariosItems entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:ComentariosItems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComentariosItems entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:ComentariosItems:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ComentariosItems entity.
    *
    * @param ComentariosItems $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ComentariosItems $entity)
    {
        $form = $this->createForm(new ComentariosItemsType(), $entity, array(
            'action' => $this->generateUrl('comentarios_items_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ComentariosItems entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:ComentariosItems')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ComentariosItems entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('comentarios_items_edit', array('id' => $id)));
        }

        return $this->render('ElearnBundle:ComentariosItems:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ComentariosItems entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ElearnBundle:ComentariosItems')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ComentariosItems entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('comentarios_items'));
    }

    /**
     * Creates a form to delete a ComentariosItems entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comentarios_items_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
