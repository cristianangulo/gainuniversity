<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Admin\Modulos\Modulos;
use AppBundle\Form\Admin\Modulos\ModulosType;

use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Admin\Modulos\ModuloItems;
/**
 * Modulos controller.
 *
 */
class ModulosController extends Controller
{

    /**
     * Lists all Modulos entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Admin\Modulos\Modulos')->findAll();

        return $this->render('Admin/Modulos/index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new Modulos entity.
     *
     */
    public function newAction(Request $request)
    {
        $modulo = new Modulos();
        $moduloForm = $this->createForm(new ModulosType(), $modulo);
        $moduloForm->handleRequest($request);

        if ($moduloForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($modulo);
            $em->flush();

            $this->get('app.mensajero')->add('mensaje','El Módulo ha sido creado');
            return $this->redirect($this->generateUrl('admin_modulos_edit', array('id' => $modulo->getId())));
        }



        return $this->render('Admin/Modulos/new.html.twig', array(
            'modulo' => $modulo,
            'modulo_form'   => $moduloForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Modulos entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $modulo = $em->getRepository('AppBundle:Admin\Modulos\Modulos')->find($id);

        if (!$modulo) {
            throw $this->createNotFoundException('Unable to find Modulos entity.');
        }

        $originalItems = new ArrayCollection();

        foreach($modulo->getSecciones() as $item){
          $originalItems->add($item);
        }

        $form = $this->createEditForm($modulo);

        $form->handleRequest($request);
        $deleteForm = $this->createDeleteForm($id);

        if ($form->isValid()) {
          foreach($originalItems as $o){
          if(false === $modulo->getSecciones()->contains($o)){
            //$o->getOrden()->removeElement($ordenCompra);
            //$o->setOrden(null);
            $em->remove($o);
            //$em->persist($o);
          }
        }

        foreach($form->getData()->getSecciones() as $item){
          if(!$item->getId()){
            $moduloSecciones = new ModuloItems();

            $modulo = $em->getRepository('AppBundle:Admin\Modulos\Modulos')->find($modulo);
            $secciones = count($originalItems) + 1;
            $moduloSecciones->setPosicion($secciones);
            $moduloSecciones->setModulos($modulo);
            $seccion = $em->getRepository('AppBundle:Admin\Items\Items')->find($item->getSecciones()->getId());
            $moduloSecciones->setSecciones($seccion);

            $em->persist($moduloSecciones);
          }
        }


          $em->flush();

          $this->get('app.mensajero')->add('mensaje','El Módulo se ha actualizado');

          return $this->redirect($this->generateUrl('admin_modulos_edit', array('id' => $id)));
        }

        return $this->render('Admin/Modulos/edit.html.twig', array(
            'entity'      => $modulo,
            'form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Modulos entity.
    *
    * @param Modulos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Modulos $entity)
    {
        $form = $this->createForm(new ModulosType(), $entity, array(
            'action' => "",
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing Modulos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:Modulos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Modulos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_modulos_edit', array('id' => $id)));
        }

        return $this->render('ElearnBundle:Modulos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Modulos entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ElearnBundle:Modulos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Modulos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_modulos'));
    }

    /**
     * Creates a form to delete a Modulos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_modulos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
