<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Quiz\QuizBundle\Entity\Quiz;
use Quiz\QuizBundle\Form\QuizType;

use Quiz\QuizBundle\Form\QuizPreguntasType;

use Quiz\QuizBundle\Entity\Preguntas;
use Quiz\QuizBundle\Form\PreguntasType;


use Quiz\QuizBundle\Entity\Opciones;
use Quiz\QuizBundle\Form\OpcionesType;

use Quiz\QuizBundle\Form\PreguntaOpcionesType;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * Quiz controller.
 *
 */
class QuizController extends Controller
{

    /**
     * Lists all Quiz entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('QuizBundle:Quiz')->findAll();

        return $this->render('QuizBundle:Quiz:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Quiz entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Quiz();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_quiz_show', array('id' => $entity->getId())));
        }

        return $this->render('QuizBundle:Quiz:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Quiz entity.
     *
     * @param Quiz $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Quiz $entity)
    {
        $form = $this->createForm(new QuizType(), $entity, array(
            'action' => $this->generateUrl('admin_quiz_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Quiz entity.
     *
     */
    public function newAction()
    {
        $entity = new Quiz();
        $form   = $this->createCreateForm($entity);

        return $this->render('QuizBundle:Quiz:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Quiz entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QuizBundle:Quiz')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quiz entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('QuizBundle:Quiz:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Quiz entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QuizBundle:Quiz')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quiz entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $preguntas = new Preguntas();

        $preguntasForm = $this->createForm(new PreguntasType(), $preguntas);
        $preguntasForm->add('submit','submit');
        $preguntasForm->handleRequest($request);

        if($preguntasForm->isValid()){

          $posicion = count($entity->getPreguntas()) + 1;

          $preguntas->setQuiz($entity);
          $preguntas->setPosicion($posicion);
          $em->persist($preguntas);
          $em->flush();

          return $this->redirect($this->generateUrl('admin_quiz_edit', array('id' => $entity->getId())));
        }

        $preguntasOriginal = new ArrayCollection;

        foreach($entity->getPreguntas() as $p){
          $preguntasOriginal->add($p);
        }

        $quizPreguntasForm = $this->quizPreguntasForm($entity);

        $quizPreguntasForm->handleRequest($request);

        if($quizPreguntasForm->isValid()){

          foreach($preguntasOriginal as $p){
            if(false === $entity->getPreguntas()->contains($p)){
              $em->remove($p);
            }
          }
          $em->flush();

          return $this->redirect($this->generateUrl('admin_quiz_edit', array('id' => $entity->getId())));
        }

        return $this->render('QuizBundle:Quiz:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            //'opciones_form' => $opcionesForm->createView(),
            //'quiz_opciones_form' => $quizOpcionesForm->createView(),
            'preguntas_form' => $preguntasForm->createView(),
            'quiz_preguntas_form' => $quizPreguntasForm->createView()
        ));
    }

    public function crearQuizOpcionesForm(Opciones $entity)
    {
      $form = $this->createForm(new OpcionesType, $entity, array(
        'action' => '',
        'method' => 'POST'
      ));

      $form->add('submit', 'submit', array('label' => 'Agregar'));

      return $form;
    }

    /**
    * Creates a form to edit a Quiz entity.
    *
    * @param Quiz $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Quiz $entity)
    {
        $form = $this->createForm(new QuizType(), $entity, array(
            'action' => $this->generateUrl('admin_quiz_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    /**
     * Edits an existing Quiz entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QuizBundle:Quiz')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quiz entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_quiz_edit', array('id' => $id)));
        }

        return $this->render('QuizBundle:Quiz:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function quizPreguntasForm(Quiz $entity)
    {
      $form = $this->createForm(new QuizPreguntasType(), $entity, array(
        'action' => '',
        'method' => 'POST'
      ));
      $form->add('submit', 'submit', array('label' => 'Guardar'));
      return $form;
    }

    /**
     * Deletes a Quiz entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QuizBundle:Quiz')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Quiz entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_quiz'));
    }

    /**
     * Creates a form to delete a Quiz entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_quiz_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function preguntaAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $entity = $em->getRepository('QuizBundle:Preguntas')->find($id);

      if (!$entity) {
          throw $this->createNotFoundException('Esta entidad no existe.');
      }

      $opciones = new Opciones();
      $opcionesForm = $this->crearQuizOpcionesForm($opciones);

      $opcionesForm->handleRequest($request);

      if($opcionesForm->isSubmitted() && $opcionesForm->isValid()){

        $posicion = count($entity->getOpciones()) + 1;
        $opciones->setPreguntas($entity);
        $opciones->setPosicion($posicion);
        $em->persist($opciones);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_quiz_pregunta', array('id' => $entity->getId())));
      }

      $opcionesOriginales = new ArrayCollection();

      foreach($entity->getOpciones() as $o){
        $opcionesOriginales->add($o);
      }



      $preguntaOpcionesForm = $this->createForm(new PreguntaOpcionesType(), $entity);
      $preguntaOpcionesForm->handleRequest($request);

      if($preguntaOpcionesForm->isValid()){

        foreach($opcionesOriginales as $o){
          if(false === $entity->getOpciones()->contains($o)){
            $em->remove($o);
          }
        }

        $em->flush();
        return $this->redirect($this->generateUrl('admin_quiz_pregunta', array('id' => $entity->getId())));
      }

      return $this->render('QuizBundle:Quiz:pregunta.html.twig', array(
        'entity' => $entity,
        'opciones_form' => $opcionesForm->createView(),
        'pregunta_opciones_form' => $preguntaOpcionesForm->createView()
      ));
    }
}
