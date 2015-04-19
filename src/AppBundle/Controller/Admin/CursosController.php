<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Admin\Cursos\Cursos;
use AppBundle\Form\Admin\Cursos\CursosType;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Admin\Cursos\CursoModulos;


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

        $entities = $em->getRepository('AppBundle:Admin\Cursos\Cursos')->findAll();

        return $this->render('Admin/Cursos/index.html.twig', array(
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

        return $this->render('Admin/Cursos/new.html.twig', array(
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
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $curso = $em->getRepository('AppBundle:Admin\Cursos\Cursos')->find($id);

        if (!$curso) {
            throw $this->createNotFoundException('Unable to find Cursos entity.');
        }

        $originalModulos = new ArrayCollection();

        foreach($curso->getModulos() as $modulo){
          $originalModulos->add($modulo);
        }

        $form = $this->createEditForm($curso);

        $form->handleRequest($request);
        $deleteForm = $this->createDeleteForm($id);

        if ($form->isValid()) {
          foreach($originalModulos as $o){
            if(false === $curso->getModulos()->contains($o)){
              //$o->getOrden()->removeElement($ordenCompra);
              //$o->setOrden(null);
              $em->remove($o);
              //$em->persist($o);
            }
          }

        foreach($form->getData()->getModulos() as $modulo){
          if(!$modulo->getId()){
            $cursoModulos = new CursoModulos();

            //$modulo = $em->getRepository('ElearnBundle:Modulos')->find($modulo);
            $cursoModulos->setPosicion(count($originalModulos) + 1);
            $cursoModulos->setCursos($curso);
            $modulo = $em->getRepository('AppBundle:Admin\Modulos\Modulos')->find($modulo->getModulos()->getId());
            $cursoModulos->setModulos($modulo);

            $em->persist($cursoModulos);
          }
        }

        $em->flush();

        return $this->redirect($this->generateUrl('admin_cursos_edit', array('id' => $id)));
      }


        return $this->render('Admin/Cursos/edit.html.twig', array(
            'entity'      => $curso,
            'form'   => $form->createView(),
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
            'action' => "",
            'method' => 'PUT',
        ));

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
