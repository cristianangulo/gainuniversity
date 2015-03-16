<?php

namespace Elearn\ElearnBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elearn\ElearnBundle\Entity\Cursos;
use Elearn\ElearnBundle\Form\CursosType;

/**
 * Cursos controller.
 *
 */
class CursosController extends Controller
{

    /**
     * Lists all Cursos entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ElearnBundle:Cursos')->findAll();

        return $this->render('ElearnBundle:Cursos:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Cursos entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Cursos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_edit', array('id' => $entity->getId())));
        }

        return $this->render('ElearnBundle:Cursos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cursos entity.
     *
     * @param Cursos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cursos $entity)
    {
        $form = $this->createForm(new CursosType(), $entity, array(
            'action' => $this->generateUrl('admin_cursos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Cursos entity.
     *
     */
    public function newAction()
    {
        $entity = new Cursos();
        $form   = $this->createCreateForm($entity);

        return $this->render('ElearnBundle:Cursos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cursos entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:Cursos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cursos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:Cursos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cursos entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:Cursos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cursos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:Cursos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Cursos entity.
    *
    * @param Cursos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cursos $entity)
    {
        $form = $this->createForm(new CursosType(), $entity, array(
            'action' => $this->generateUrl('admin_cursos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }
    /**
     * Edits an existing Cursos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:Cursos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cursos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_edit', array('id' => $id)));
        }

        return $this->render('ElearnBundle:Cursos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Cursos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ElearnBundle:Cursos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cursos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_cursos'));
    }

    /**
     * Creates a form to delete a Cursos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_cursos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
