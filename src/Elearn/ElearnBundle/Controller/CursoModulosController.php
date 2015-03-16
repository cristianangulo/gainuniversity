<?php

namespace Elearn\ElearnBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elearn\ElearnBundle\Entity\CursoModulos;
use Elearn\ElearnBundle\Form\CursoModulosType;

/**
 * CursoModulos controller.
 *
 */
class CursoModulosController extends Controller
{

    /**
     * Lists all CursoModulos entities.
     *
     */
    public function indexAction($curso, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('ElearnBundle:CursoModulos')->findAll($curso);

        $entities = $em->getRepository('ElearnBundle:CursoModulos');

        $entities = $entities->createQueryBuilder('m')
          ->where('m.cursos = :curso')
          ->setParameter('curso', $curso)
          ->getQuery()
          ->getResult();

        $entity = new CursoModulos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $curso = $em->getRepository('ElearnBundle:Cursos')->find($curso);
            $modulos = $em->getRepository('ElearnBundle:CursoModulos')->findAll($curso->getId());
            $modulos = count($modulos) + 1;
            $entity->setCursos($curso);
            $entity->setPosicion($modulos);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_modulos', array('curso' => $curso->getId())));
        }

        return $this->render('ElearnBundle:CursoModulos:index.html.twig', array(
            'entities' => $entities,
            'entity' => $entity,
            'form'   => $form->createView(),
            'curso_id' => $curso
        ));
    }
    /**
     * Creates a new CursoModulos entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CursoModulos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $curso = $em->getRepository('ElearnBundle:Cursos')->find($curso);
            $entity->setCursos($curso);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_modulos_show', array('id' => $entity->getId())));
        }

        return $this->render('ElearnBundle:CursoModulos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CursoModulos entity.
     *
     * @param CursoModulos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CursoModulos $entity)
    {
        $form = $this->createForm(new CursoModulosType(), $entity, array(
            'action' => "",
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new CursoModulos entity.
     *
     */
    public function newAction()
    {
        $entity = new CursoModulos();
        $form   = $this->createCreateForm($entity);

        return $this->render('ElearnBundle:CursoModulos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CursoModulos entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:CursoModulos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CursoModulos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:CursoModulos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CursoModulos entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:CursoModulos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CursoModulos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:CursoModulos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CursoModulos entity.
    *
    * @param CursoModulos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CursoModulos $entity)
    {
        $form = $this->createForm(new CursoModulosType(), $entity, array(
            'action' => $this->generateUrl('admin_cursos_modulos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CursoModulos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:CursoModulos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CursoModulos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_modulos_edit', array('id' => $id)));
        }

        return $this->render('ElearnBundle:CursoModulos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CursoModulos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ElearnBundle:CursoModulos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CursoModulos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_cursos_modulos'));
    }

    public function deleteModuloCursoAction($curso, $modulo)
    {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('ElearnBundle:CursoModulos')->find($modulo);

      if (!$entity) {
          throw $this->createNotFoundException('Unable to find CursoModulos entity.');
      }

      $em->remove($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('admin_cursos_modulos', array('curso' => $curso)));

    }

    /**
     * Creates a form to delete a CursoModulos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_cursos_modulos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
