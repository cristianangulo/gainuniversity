<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Admin\Cursos\CursoUsuarios;
use AppBundle\Form\Admin\Cursos\CursoUsuariosType;

/**
 * CursoUsuarios controller.
 *
 */
class CursoUsuariosController extends Controller
{

    /**
     * Lists all CursoUsuarios entities.
     *
     */
    public function indexAction($curso, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Admin\Cursos\CursoUsuarios');

        $entities = $entities->createQueryBuilder('cu')
          ->where('cu.curso = :curso')
          ->setParameter('curso', $curso)
          ->getQuery()
          ->getResult()
        ;

        $entity = new CursoUsuarios();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $curso = $em->getRepository('AppBundle:Admin\Cursos\Cursos')->find($curso);
            $entity->setCurso($curso);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_usuarios', array('curso' => $curso->getId())));
        }

        return $this->render('ElearnBundle:CursoUsuarios:index.html.twig', array(
            'entities' => $entities,
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Creates a new CursoUsuarios entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CursoUsuarios();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_usuarios_show', array('id' => $entity->getId())));
        }

        return $this->render('ElearnBundle:CursoUsuarios:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CursoUsuarios entity.
     *
     * @param CursoUsuarios $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CursoUsuarios $entity)
    {
        $form = $this->createForm(new CursoUsuariosType(), $entity, array(
            'action' => "",
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Agregar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new CursoUsuarios entity.
     *
     */
    public function newAction()
    {
        $entity = new CursoUsuarios();
        $form   = $this->createCreateForm($entity);

        return $this->render('ElearnBundle:CursoUsuarios:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CursoUsuarios entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:CursoUsuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CursoUsuarios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:CursoUsuarios:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CursoUsuarios entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:CursoUsuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CursoUsuarios entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:CursoUsuarios:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CursoUsuarios entity.
    *
    * @param CursoUsuarios $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CursoUsuarios $entity)
    {
        $form = $this->createForm(new CursoUsuariosType(), $entity, array(
            'action' => $this->generateUrl('admin_cursos_usuarios_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CursoUsuarios entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:CursoUsuarios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CursoUsuarios entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_cursos_usuarios_edit', array('id' => $id)));
        }

        return $this->render('ElearnBundle:CursoUsuarios:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CursoUsuarios entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ElearnBundle:CursoUsuarios')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CursoUsuarios entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_cursos_usuarios'));
    }

    public function deleteUsuarioCursoAction($curso, $usuario)
    {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Admin\Cursos\CursoUsuarios')->find($usuario);

      if (!$entity) {
          throw $this->createNotFoundException('Unable to find CursoUsuarios entity.');
      }

      $em->remove($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('admin_cursos_usuarios', array('curso' => $curso)));
    }

    /**
     * Creates a form to delete a CursoUsuarios entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_cursos_usuarios_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
