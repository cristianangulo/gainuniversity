<?php

namespace Elearn\ElearnBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elearn\ElearnBundle\Entity\ModuloSecciones;
use Elearn\ElearnBundle\Form\ModuloSeccionesType;

/**
 * ModuloSecciones controller.
 *
 */
class ModuloSeccionesController extends Controller
{

    /**
     * Lists all ModuloSecciones entities.
     *
     */
    public function indexAction($modulo, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('ElearnBundle:ModuloSecciones')->findAll();

        $entities = $em->getRepository('ElearnBundle:ModuloSecciones');

        $entities = $entities->createQueryBuilder('m')
          ->where('m.modulos = :modulo')
          ->setParameter('modulo', $modulo)
          ->getQuery()
          ->getResult();

        $entity = new ModuloSecciones();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $modulo = $em->getRepository('ElearnBundle:Modulos')->find($modulo);
            $secciones = $em->getRepository('ElearnBundle:ModuloSecciones')->findAll($modulo->getId());
            $secciones = count($secciones) + 1;
            $entity->setPosicion($secciones);
            $entity->setModulos($modulo);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_modulos_secciones', array('modulo' => $modulo->getId())));
        }

        return $this->render('ElearnBundle:ModuloSecciones:index.html.twig', array(
            'entities' => $entities,
            'entity' => $entity,
            'form'   => $form->createView(),
            'modulo_id' => $modulo
        ));
    }
    /**
     * Creates a new ModuloSecciones entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ModuloSecciones();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_modulos_secciones_show', array('id' => $entity->getId())));
        }

        return $this->render('ElearnBundle:ModuloSecciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ModuloSecciones entity.
     *
     * @param ModuloSecciones $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ModuloSecciones $entity)
    {
        $form = $this->createForm(new ModuloSeccionesType(), $entity, array(
            'action' => "",
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new ModuloSecciones entity.
     *
     */
    public function newAction()
    {
        $entity = new ModuloSecciones();
        $form   = $this->createCreateForm($entity);

        return $this->render('ElearnBundle:ModuloSecciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ModuloSecciones entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:ModuloSecciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuloSecciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:ModuloSecciones:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ModuloSecciones entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:ModuloSecciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuloSecciones entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:ModuloSecciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ModuloSecciones entity.
    *
    * @param ModuloSecciones $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ModuloSecciones $entity)
    {
        $form = $this->createForm(new ModuloSeccionesType(), $entity, array(
            'action' => $this->generateUrl('admin_modulos_secciones_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ModuloSecciones entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:ModuloSecciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuloSecciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_modulos_secciones_edit', array('id' => $id)));
        }

        return $this->render('ElearnBundle:ModuloSecciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ModuloSecciones entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ElearnBundle:ModuloSecciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ModuloSecciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_modulos_secciones'));
    }

    public function deleteItemModuloAction($modulo, $item)
    {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('ElearnBundle:ModuloSecciones')->find($item);

      if (!$entity) {
          throw $this->createNotFoundException('Unable to find ModuloSecciones entity.');
      }

      $em->remove($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('admin_modulos_secciones', array('modulo' => $modulo)));

    }

    /**
     * Creates a form to delete a ModuloSecciones entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_modulos_secciones_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
