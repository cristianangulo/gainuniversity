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

        return $this->render('ElearnBundle:Secciones:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Secciones entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Items();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_secciones_edit', array('id' => $entity->getId())));
        }

        return $this->render('ElearnBundle:Secciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Secciones entity.
     *
     * @param Secciones $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Items $entity)
    {
        $form = $this->createForm(new ItemsType(), $entity, array(
            'action' => $this->generateUrl('admin_secciones_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new Secciones entity.
     *
     */
    public function newAction()
    {
        $entity = new Items();
        $form   = $this->createCreateForm($entity);

        return $this->render('ElearnBundle:Secciones:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Secciones entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ElearnBundle:Secciones')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secciones entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:Secciones:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Secciones entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Admin\Items\Items')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secciones entity.');
        }

        $editForm = $this->createEditForm($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ElearnBundle:Secciones:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
            $entity = $em->getRepository('ElearnBundle:Secciones')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Secciones entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

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
