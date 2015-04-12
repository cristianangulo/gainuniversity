<?php

namespace Elearn\ElearnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elearn\ElearnBundle\Entity\ComentariosItems;
use Elearn\ElearnBundle\Form\ComentariosItemsType;
use Symfony\Component\HttpFoundation\Request;

use ACL\ACLBundle\Entity\Usuarios;
use Elearn\ElearnBundle\Form\PerfilUsuarioType;
use Elearn\ElearnBundle\Form\PasswordUsuarioType;

use ACL\ACLBundle\Entity\CursoUsuarios;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Quiz\QuizBundle\Entity\QuizUsuario;
use Quiz\QuizBundle\Entity\QuizUsuarioDetalle;

use Quiz\QuizBundle\Entity\UsuarioQuizPreguntasOpciones;
use Quiz\QuizBundle\Form\UsuarioQuizPreguntasOpcionesType;

use Doctrine\ORM\EntityRepository;



class FrontController extends Controller
{

  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $curso = $em
    ->getRepository("ElearnBundle:Cursos")
    ->findOneById($id);

    if (!$curso) {
        throw $this->createNotFoundException(
        'Este curso no existe '.$id
      );
    }




    if ($this->get('security.context')->isGranted('ROLE_USER')) {
      // @fecha publicación curso
      $fpc = $curso->getFechaPublicacion();

      // @Usuario


      if($this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')){
        $usuario = 2;
      }else{
        $usuario = $this->getUser()->getId();
      }

      $fru = $em->getRepository('ElearnBundle:CursoUsuarios');

      $fru = $fru->createQueryBuilder('cu')
        ->where('cu.curso = :curso')
        ->andWhere('cu.usuario = :usuario')
        ->setParameter('curso', $id)
        ->setParameter('usuario', $this->getUser()->getId())
        ->getQuery()
      ;

      $fru = $fru->getSingleResult();

      /*
       * Se la fecha mayor se usa para iniciar la publicación de los módulos
       */

      $dePublicacion = ($fpc < $fru->getFechaRegistro()) ? $fru->getFechaRegistro() : $fpc;

      /*
       * Se averigua por la fecha actual
       */
      //$hoy = date_format(new \DateTime('now'), 'Y-m-d');

      $hoy = new \DateTime('now');
      $intervalo = $dePublicacion->diff($hoy)->format('%a');

      $temporalidadCurso = $curso->getTemporalidad();

      $formaPublicacion = 0;

      switch($temporalidadCurso){
        case 1:
          $formaPublicacion = 1;
          break;
        case 2:
          $formaPublicacion = 7;
          break;
        case 3:
          $formaPublicacion = 14;
      };

      // echo "Días de intérvalo: ".$intervalo."<br />";
      // echo "Forma de publicacion: ".$formaPublicacion."<br />";
      // echo "Módulos a publicar: ".($intervalo / $formaPublicacion + 1) ."<br />";
      // exit();

      $modulosCurso = count($curso->getModulos());

      $modulosPublicar = ($intervalo / $formaPublicacion + 1);
      $modulosPublicar = ($modulosPublicar < $modulosCurso) ? $modulosPublicar: $modulosCurso;


      return $this->render('elearn/curso.html.twig', array(
        "curso" => $curso,
        "modulosPublicar" => $modulosPublicar
      ));

    }else{

      return $this->render('elearn/curso.html.twig', array(
        "curso" => $curso,
        "modulosPublicar" => null
      ));
    }


  }

  public function moduloAction($curso, $modulo, $seccion, Request $request, $pregunta)
  {

    $em = $this->getDoctrine()->getManager();

    $curso = $this->getDoctrine()
    ->getRepository("ElearnBundle:Cursos")
    ->find($curso);
    $modulo = $this->getDoctrine()
    ->getRepository("ElearnBundle:Modulos")
    ->find($modulo);

    $seccion = $this->getDoctrine()
    ->getRepository("ElearnBundle:Secciones")
    ->find($seccion);

    if(!$seccion){
      throw $this->createNotFoundException(
      'Este item no existe'
      );
    }

    if($seccion->getTipo()->getId()==6){
      return $this->render('ElearnBundle:Front:audio-descarga.html.twig', array(
        "curso" => $curso,
        "modulo" => $modulo,
        "seccion" => $seccion,
        "seccion_id" => $seccion->getId(),
      ));
    }

    if($seccion->getTipo()->getId()==5){

      $quizUsuario = $this->getQuizUsuario($curso, $modulo, $seccion, $this->getUser());

      if(null == $quizUsuario ){

      $qUsuario = new QuizUsuario();

      $quizUsuarioForm = $this->createFormBuilder($qUsuario)
        ->getForm();

      $quizUsuarioForm->handleRequest($request);

      if($quizUsuarioForm->isValid()){
        $qUsuario->setCursos($curso);
        $qUsuario->setModulos($modulo);
        $qUsuario->setItems($seccion);

        $quiz = $em->getRepository("QuizBundle:Quiz")->find($seccion->getQuiz()->getId());

        $qUsuario->setQuizes($quiz);

        $usuario = $em->getRepository("ACLBundle:Usuarios")->find($this->getUser()->getId());

        $qUsuario->setUsuarios($usuario);
        $qUsuario->setCalificacion("");
        $em->persist($qUsuario);
        $em->flush();

        return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'seccion' => $seccion->getId())));
      }

        return $this->render('ElearnBundle:Front:quiz.html.twig', array(
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
        return $this->render('ElearnBundle:Front:respuestas.html.twig', array(
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
          'class' => 'QuizBundle:Opciones',
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

        $quiz = $em->getRepository("QuizBundle:QuizUsuario")->find($quizUsuario["quizUsuario"]);

        $quizUsuarioDetalle->setQuizes($quiz);
        $formData = $opcionesForm->getData();

        $pregunta = $em->getRepository("QuizBundle:Preguntas")->find($preguntaActual);

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

      $pregunta = $em->getRepository("QuizBundle:Preguntas")->find($preguntaActual);

      return $this->render('ElearnBundle:Front:quiz-respuestas.html.twig', array(
        "curso" => $curso,
        "modulo" => $modulo,
        "seccion" => $seccion,
        "seccion_id" => $seccion->getId(),
        'pregunta' => $pregunta,
        'opciones_form' => $opcionesForm->createView()
      ));
    }


  // $comentarios = $em->getRepository("ElearnBundle:ComentariosItems")->findAll();

  $comentarios = $em->getRepository('ElearnBundle:ComentariosItems');

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

    $usuario = $em->getRepository('ACLBundle:Usuarios')->findOneByUsername($usuario->getUsername());

    $curso = $em->getRepository('ElearnBundle:Cursos')->findOneById($curso);
    $modulo = $em->getRepository('ElearnBundle:Modulos')->findOneById($modulo);
    $items = $em->getRepository('ElearnBundle:Secciones')->findOneById($seccion);

    $comentario->setUsuarios($usuario);
    $comentario->setCursos($curso);
    $comentario->setModulos($modulo);
    $comentario->setItems($items);

    $em->persist($comentario);
    $em->flush();

    return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'seccion' => $seccion->getId())));
  }

    return $this->render('ElearnBundle:Front:modulo.html.twig', array(
      "curso" => $curso,
      "modulo" => $modulo,
      "seccion" => $seccion,
      "seccion_id" => $seccion->getId(),
      "comentarioForm" => $comentarioForm->createView(),
      "comentarios" => $comentarios,
    ));
  }

  public function perfilAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $usuario = $this->get('security.context')->getToken()->getUser();

    $usuario = $em->getRepository("ACLBundle:Usuarios")->find($usuario->getId());

    $formPerfil = $this->createForm(new PerfilUsuarioType(), $usuario);
    $formPassword = $this->createForm(new PasswordUsuarioType(), $usuario);

    $formPerfil->handleRequest($request);
    $formPassword->handleRequest($request);

    if($formPerfil->isValid()){
      $em->flush();
      return $this->redirect($this->generateUrl('front_perfil'));
    }

    if($formPassword->isValid()){
      $factory = $this->get('security.encoder_factory');
      $encoder = $factory->getEncoder($usuario);
      $formData = $formPassword->getData();
      $usuario->setPassword($encoder->encodePassword($formData->getPassword(), $usuario->getSalt()));
      $em->flush();
      return $this->redirect($this->generateUrl('front_perfil'));
    }

    return $this->render('ElearnBundle:Front:perfil.html.twig', array(
      'formPerfil' => $formPerfil->createView(),
      'formPassword' => $formPassword->createView(),
      'usuario' => $usuario
    ));
  }

  public function getPreguntasResultas($id)
  {
    $em = $this->getDoctrine()->getManager();

    $preguntasResueltas = $em->getRepository("QuizBundle:QuizUsuarioDetalle");

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

    $quizUsuario = $em->getRepository("QuizBundle:QuizUsuario");

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

  public function tusCursosAction()
  {
    $em = $this->getDoctrine()->getManager();
    $usuario = $this->get('security.context')->getToken()->getUser();

    $usuario = $em->getRepository("ACLBundle:Usuarios")->find($usuario->getId());

    return $this->render('ElearnBundle:Front:tus-cursos.html.twig', array(
      'usuario' => $usuario
    ));
  }
}
