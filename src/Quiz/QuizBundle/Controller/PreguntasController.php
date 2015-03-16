<?php

namespace Quiz\QuizBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Quiz\QuizBundle\Entity\Preguntas;
use Quiz\QuizBundle\Form\PreguntasType;

use Quiz\QuizBundle\Entity\Respuestas;
use Quiz\QuizBundle\Form\RespuestasType;

/**
 * Preguntas controller.
 *
 */
class PreguntasController extends Controller
{
    private $preguntaId;

    public function preguntaId($preguntaId)
    {
      $this->preguntaId = $preguntaId;
    }
    /**
     * Lists all Preguntas entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('QuizBundle:Preguntas')->findAll();

        return $this->render('QuizBundle:Preguntas:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Preguntas entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Preguntas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_quiz_preguntas_show', array('id' => $entity->getId())));
        }

        return $this->render('QuizBundle:Preguntas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Preguntas entity.
     *
     * @param Preguntas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Preguntas $entity)
    {
        $form = $this->createForm(new PreguntasType(), $entity, array(
            'action' => $this->generateUrl('admin_quiz_preguntas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Preguntas entity.
     *
     */
    public function newAction()
    {
        $entity = new Preguntas();
        $form   = $this->createCreateForm($entity);

        return $this->render('QuizBundle:Preguntas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Preguntas entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QuizBundle:Preguntas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preguntas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('QuizBundle:Preguntas:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Preguntas entity.
     *
     */
    public function editAction($id)
    {
        $this->preguntaId($id);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QuizBundle:Preguntas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preguntas entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $respuestas = new Respuestas();

        $respuestasForm = $this->crearRespuestaForm($respuestas);

        return $this->render('QuizBundle:Preguntas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'respuestas_form' => $respuestasForm->createView()
        ));
    }

    public function crearRespuestaForm(Respuestas $entity)
    {

      $form = $this->createForm(new RespuestasType(), $entity, array(
          'action' => $this->generateUrl('admin_quiz_respuestas_crear'),
          'method' => 'POST',
      ));

      $form->add('pregunta', 'hidden', array('mapped'=> false, 'data' => $this->preguntaId ));
      $form->add('submit', 'submit', array('label' => 'Create'));

      return $form;
    }

    public function crearRespuestaAction(Request $request)
    {

        $entity = new Respuestas();
        $form = $this->crearRespuestaForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $pregunta = $form->get('pregunta')->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_quiz_preguntas_edit', array('id' => $entity->getPreguntas())));
        }

        return $this->render('QuizBundle:Preguntas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a Preguntas entity.
    *
    * @param Preguntas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Preguntas $entity)
    {
        $form = $this->createForm(new PreguntasType(), $entity, array(
            'action' => $this->generateUrl('admin_quiz_preguntas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Preguntas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QuizBundle:Preguntas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Preguntas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_quiz_preguntas_edit', array('id' => $id)));
        }

        return $this->render('QuizBundle:Preguntas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Preguntas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QuizBundle:Preguntas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Preguntas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_quiz_preguntas'));
    }

    /**
     * Creates a form to delete a Preguntas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_quiz_preguntas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
