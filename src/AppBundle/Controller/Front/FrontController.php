<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Front\ComentariosItems;
use AppBundle\Form\Front\ComentariosItemsType;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\ACL\Usuarios;
use AppBundle\Form\ACL\PerfilUsuarioType;
use Elearn\ElearnBundle\Form\PasswordUsuarioType;

use ACL\ACLBundle\Entity\CursoUsuarios;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\Admin\Quiz\QuizUsuario;
use AppBundle\Entity\Admin\Quiz\QuizUsuarioDetalle;

use AppBundle\Entity\Admin\Quiz\UsuarioQuizPreguntasOpciones;
use AppBundle\Form\Admin\Quiz\UsuarioQuizPreguntasOpcionesType;

use Doctrine\ORM\EntityRepository;



class FrontController extends Controller
{
    public function homeAction()
    {


        return $this->render('Elearn/home.html.twig');
    }

  public function moduloAction($curso, $modulo, $seccion, Request $request, $pregunta)
  {
    $em = $this->getDoctrine()->getManager();

    $repositorio = $em->getRepository('AppBundle:Admin\Cursos\Cursos');

    $curso = $repositorio->createQueryBuilder('c')
      ->select('c','m','i','s')
      ->leftJoin('c.modulos','m')
      ->leftJoin('m.modulos', 'i')
      ->leftJoin('i.secciones','s')
      ->where('c.id = :curso')
      ->andWhere('m.modulos = :modulo')
      ->andWhere('s.secciones = :item')
      ->setParameter('curso', $curso)
      ->setParameter('modulo', $modulo)
      ->setParameter('item', $seccion)
      ->getQuery()
      ->getSingleResult()
    ;

    echo $curso->getId();

    foreach($curso->getModulos() as $m){
      echo count($m->getModulos()->getSecciones());
    }
    echo count($curso->getModulos());



    exit();

    $curso = $this->getDoctrine()
    ->getRepository("AppBundle:Admin\Cursos\Cursos")
    ->find($curso);
    $modulo = $this->getDoctrine()
    ->getRepository("AppBundle:Admin\Modulos\Modulos")
    ->find($modulo);

    $seccion = $this->getDoctrine()
    ->getRepository("AppBundle:Admin\Items\Items")
    ->find($seccion);

    if(!$seccion){
      throw $this->createNotFoundException(
      'Este item no existe'
      );
    }

    if($seccion->getTipo()->getId()==6){
      return $this->render('Front/audio-descarga.html.twig', array(
        "curso" => $curso,
        "modulo" => $modulo,
        "seccion" => $seccion,
        "seccion_id" => $seccion->getId(),
      ));
    }

    if($seccion->getTipo()->getId()==5){

      $quizUsuario = $this->getQuizUsuario($curso, $modulo, $seccion, $this->getUser());

      if(null == $quizUsuario){
        exit();
        $qUsuario = new QuizUsuario();

        $quizUsuarioForm = $this->createFormBuilder($qUsuario)->getForm();

        $quizUsuarioForm->handleRequest($request);

      if($quizUsuarioForm->isValid()){

        $qUsuario->setCursos($curso);
        $qUsuario->setModulos($modulo);
        $qUsuario->setItems($seccion);

        $quiz = $em->getRepository("AppBundle:Admin\Quiz\Quiz")->find($seccion->getQuiz()->getId());

        $qUsuario->setQuizes($quiz);

        $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->find($this->getUser()->getId());

        $qUsuario->setUsuarios($usuario);
        $qUsuario->setCalificacion("");
        $em->persist($qUsuario);
        $em->flush();

        return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'seccion' => $seccion->getId())));
      }

        return $this->render('Front/quiz.html.twig', array(
          "curso" => $curso,
          "modulo" => $modulo,
          "seccion" => $seccion,
          "seccion_id" => $seccion->getId(),
          'quiz_usuario_form' => $quizUsuarioForm->createView()
        ));
      }


      /**
       * De la entidad sección se necesita saber cuántas preguntas hay y generar un Array
       */

      $preguntas = array();

      foreach($seccion->getQuiz()->getPreguntas() as $key => $p){
        $preguntas[$p->getId()] = $p->getId();
      }

      $preguntasResueltas = $this->getPreguntasResultas($quizUsuario["quizUsuario"]);
      $quiz = $quizUsuario["quizItem"];

      if(count($preguntas) === count($preguntasResueltas)){
        return $this->render('Front/respuestas.html.twig', array(
          "curso" => $curso,
          "modulo" => $modulo,
          "seccion" => $seccion,
          "seccion_id" => $seccion->getId(),
          "quiz" => $preguntasResueltas
        ));
      }

      $preguntaActual = 0;
      if(null == $pregunta){
        $preguntaActual = current($preguntas);
        $siguientePregunta = next($preguntas);

        foreach($preguntasResueltas as $p){
          if($p->getPreguntas()->getId() === $preguntaActual){

            unset($preguntas[$preguntaActual]);

            foreach($preguntas as $x){

              if($x != $p->getPreguntas()->getId()){
                return $this->redirect($this->generateUrl('front_modulo', array(
                  'curso' => $curso->getId(),
                  'modulo'=> $modulo->getId(),
                  'seccion' => $seccion->getId(),
                  'pregunta' => $x
                )));
              }
            }

          }
        }
      }else{
        /**
         * Si el valor de la url pregunta no es nulo
         * el valor de la pregunta actual será el valor pasado por url
         */

        $preguntaActual = $preguntas[$pregunta];

          foreach($preguntasResueltas as $p){

            unset($preguntas[$p->getPreguntas()->getId()]);

            if($p->getPreguntas()->getId() === $preguntaActual){

              foreach($preguntas as $x){
                if($x != $p->getPreguntas()->getId()){
                  return $this->redirect($this->generateUrl('front_modulo', array(
                    'curso' => $curso->getId(),
                    'modulo'=> $modulo->getId(),
                    'seccion' => $seccion->getId(),
                    'pregunta' => $x
                  )));
                }
              }
            }
          }

          $siguientePregunta = next($preguntas);
      }

      $quizUsuarioDetalle = new QuizUsuarioDetalle();

      $opcionesForm = $this->createFormBuilder($quizUsuarioDetalle)
        ->add('opciones', 'entity', array(
          'class' => 'AppBundle:Admin\Quiz\Opciones',
          'query_builder' => function(EntityRepository $er) use($preguntaActual, $quiz){
              return $er->createQueryBuilder('o')
                ->innerJoin('o.preguntas','p')
                ->where('o.preguntas = :pregunta')
                ->andWhere('p.quiz = :quiz')
                ->setParameter('pregunta', $preguntaActual)
                ->setParameter('quiz', $quiz);
            },
          'property' => 'opcion',
          'expanded' => true
        ))
        ->getForm()
      ;

      $opcionesForm->handleRequest($request);

      if($opcionesForm->isValid()){

        $quiz = $em->getRepository("AppBundle:Admin\Quiz\QuizUsuario")->find($quizUsuario["quizUsuario"]);

        $quizUsuarioDetalle->setQuizes($quiz);
        $formData = $opcionesForm->getData();

        $pregunta = $em->getRepository("AppBundle:Admin\Quiz\Preguntas")->find($preguntaActual);

        $quizUsuarioDetalle->setPreguntas($pregunta);
        $quizUsuarioDetalle->setCalificacion($formData->getOpciones()->getValor());

        $em->persist($quizUsuarioDetalle);
        $em->flush();

        return $this->redirect($this->generateUrl('front_modulo', array(
          'curso' => $curso->getId(),
          'modulo'=> $modulo->getId(),
          'seccion' => $seccion->getId(),
          'pregunta' => $siguientePregunta
        )));
      }

      $pregunta = $em->getRepository("AppBundle:Admin\Quiz\Preguntas")->find($preguntaActual);

      return $this->render('Front/quiz-respuestas.html.twig', array(
        "curso" => $curso,
        "modulo" => $modulo,
        "seccion" => $seccion,
        "seccion_id" => $seccion->getId(),
        'pregunta' => $pregunta,
        'opciones_form' => $opcionesForm->createView()
      ));
    }


  // $comentarios = $em->getRepository("ElearnBundle:ComentariosItems")->findAll();

  $comentarios = $em->getRepository('AppBundle:Front\ComentariosItems');

  $comentarios = $comentarios->createQueryBuilder('i')
    ->where('i.items = :item')
      ->andWhere('i.modulos = :modulo')
      ->andWhere('i.cursos = :curso')
    ->setParameter('item', $seccion)
      ->setParameter('modulo', $modulo)
      ->setParameter('curso', $curso)
    ->getQuery()
    ->getResult();

  $comentario = new ComentariosItems();
  $comentarioForm = $this->createForm(new ComentariosItemsType(), $comentario, array(
    'action' => "",
    'method' => 'POST',
  ));

  $comentarioForm->handleRequest($request);

  if($comentarioForm->isValid()){
    $em = $this->getDoctrine()->getManager();

    $usuario = $this->get('security.context')->getToken()->getUser();

    $usuario = $em->getRepository('AppBundle:ACL\Usuarios')->findOneByUsername($usuario->getUsername());

    $curso = $em->getRepository('AppBundle:Admin\Cursos\Cursos')->findOneById($curso);
    $modulo = $em->getRepository('AppBundle:Admin\Modulos\Modulos')->findOneById($modulo);
    $items = $em->getRepository('AppBundle:Admin\Items\Items')->findOneById($seccion);

    $comentario->setUsuarios($usuario);
    $comentario->setCursos($curso);
    $comentario->setModulos($modulo);
    $comentario->setItems($items);

    $em->persist($comentario);
    $em->flush();

    return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'seccion' => $seccion->getId())));
  }

    return $this->render('Front/modulo.html.twig', array(
      "curso" => $curso,
      "modulo" => $modulo,
      "seccion" => $seccion,
      "seccion_id" => $seccion->getId(),
      "comentarioForm" => $comentarioForm->createView(),
      "comentarios" => $comentarios,
    ));
  }

  public function getPreguntasResultas($id)
  {
    $em = $this->getDoctrine()->getManager();

    $preguntasResueltas = $em->getRepository("AppBundle:Admin\Quiz\QuizUsuarioDetalle");

    $preguntasResueltas = $preguntasResueltas->createQueryBuilder('p')
      ->andWhere('p.quizes  = :quiz')
      ->setParameter('quiz', $id)
      ->getQuery()
      ->getResult();

      return $preguntasResueltas;
  }

  public function getQuizUsuario($curso, $modulo, $item, $usuario)
  {
    $em = $this->getDoctrine()->getManager();

    $quizUsuario = $em->getRepository("AppBundle:Admin\Quiz\QuizUsuario");

    $quizUsuario = $quizUsuario->createQueryBuilder('p')
      ->where('p.cursos     = :curso')
      ->andWhere('p.modulos = :modulo')
      ->andWhere('p.items   =  :item')
      ->andWhere('p.usuarios  = :usuario')
      ->setParameter('curso', $curso->getId())
      ->setParameter('modulo', $modulo->getId())
      ->setParameter('item', $item->getId())
      ->setParameter('usuario', $usuario->getId())
      ->getQuery()
      ->getResult();

    $qUsuario = array();
      foreach($quizUsuario as $q){
        $qUsuario["quizUsuario"] = $q->getId();
        $qUsuario["quizItem"] = $q->getQuizes()->getId();
      }
      return $qUsuario;
  }
}
