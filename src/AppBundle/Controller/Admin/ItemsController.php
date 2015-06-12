<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Admin\Items\Items;
use AppBundle\Form\Admin\Items\ItemsType;

/**
 * Secciones controller.
 *
 */
class ItemsController extends Controller
{

    /**
     * Lists all Secciones entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Admin\Items\Items')->findAll();

        return $this->render('Admin/Items/index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new Secciones entity.
     *
     */
    public function newAction(Request $request)
    {
        $item = new Items();
        $itemForm   = $this->createForm(new ItemsType(), $item);

        $itemForm->handleRequest($request);

        if ($itemForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->get('app.mensajero')->add('info', 'El Ítem se ha creado');

            return $this->redirect($this->generateUrl('admin_secciones_edit', array('id' => $item->getId())));
        }

        return $this->render('Admin/Items/new.html.twig', array(
            'item' => $item,
            'item_form'   => $itemForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Secciones entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository('AppBundle:Admin\Items\Items')->find($id);

        if (!$item) {
            throw $this->createNotFoundException('Unable to find Secciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $itemForm = $this->createForm(new ItemsType(), $item);
        $itemForm->handleRequest($request);

        if ($itemForm->isValid()) {

            $item->upload();
            $em->flush();

            $this->get('app.mensajero')->add('info', 'El Ítem se ha actualizado');

            return $this->redirect($this->generateUrl('admin_secciones_edit', array('id' => $item->getId())));
        }

        return $this->render('Admin/Items/edit.html.twig', array(
            'item'        => $item,
            'item_form'   => $itemForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Secciones entity.
    *
    * @param Secciones $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Items $entity)
    {
        $form = $this->createForm(new ItemsType(), $entity, array(
            'action' => $this->generateUrl('admin_secciones_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }
    /**
     * Edits an existing Secciones entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Admin\Items\Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->upload();
            $em->flush();
            return $this->redirect($this->generateUrl('admin_secciones_edit', array('id' => $id)));
        }

        return $this->render('ElearnBundle:Secciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Secciones entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Admin\Items\Items')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Secciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('app.mensajero')->add('warning', 'El Ítem ha sido borrado');
        return $this->redirect($this->generateUrl('admin_secciones'));
    }

    public function deleteArchivoAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Admin\Items\Items')->find($id);

      if (!$entity) {
          throw $this->createNotFoundException('Unable to find Secciones entity.');
      }

      $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

      $server = $_SERVER["DOCUMENT_ROOT"]."uploads/documents/";

      unlink($server.$entity->getPath());

      $entity->setPath('');
      $em->flush();



      return $this->redirect($this->generateUrl('admin_secciones_edit', array('id' => $id)));
    }

    /**
     * Creates a form to delete a Secciones entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_secciones_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' =>  'Eliminar', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
