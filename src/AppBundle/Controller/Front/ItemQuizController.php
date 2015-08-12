<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ACL\ACLBundle\Entity\CursoUsuarios;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\Admin\Quiz\QuizUsuario;
use AppBundle\Entity\Admin\Quiz\QuizUsuarioDetalle;

use AppBundle\Entity\Admin\Quiz\UsuarioQuizPreguntasOpciones;
use AppBundle\Form\Admin\Quiz\UsuarioQuizPreguntasOpcionesType;

use Doctrine\ORM\EntityRepository;


class ItemQuizController extends Controller
{

    public function itemQuizAction($curso, $modulo, $item, Request $request, $pregunta)
    {
        $curso = $this->get('app.model.cursos')->curso($curso);
        $modulo = $this->get('app.model.modulos')->modulo($modulo);
        $item = $this->get('app.model.items')->item($item);

        $quizUsuario = $this->getQuizUsuario($curso, $modulo, $item, $this->getUser());

        if(null == $quizUsuario){

          $qUsuario = new QuizUsuario();

          $quizUsuarioForm = $this->createFormBuilder($qUsuario)->getForm();

          $quizUsuarioForm->handleRequest($request);

        if($quizUsuarioForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $qUsuario->setCursos($curso);
            $qUsuario->setModulos($modulo);
            $qUsuario->setItems($item);

            $quiz = $em->getRepository("AppBundle:Admin\Quiz\Quiz")->find($item->getQuiz()->getId());

            $qUsuario->setQuizes($quiz);

            $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->find($this->getUser()->getId());

            $qUsuario->setUsuarios($usuario);
            $qUsuario->setCalificacion("");
            $em->persist($qUsuario);
            $em->flush();

            return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'seccion' => $item->getId())));
        }

          return $this->render('Front/quiz.html.twig', array(
            "curso" => $curso,
            "modulo" => $modulo,
            "item" => $item,
            "item_id" => $item->getId(),
            'quiz_usuario_form' => $quizUsuarioForm->createView()
          ));
        }


        /**
         * De la entidad sección se necesita saber cuántas preguntas hay y generar un Array
         */

        $preguntas = array();

        foreach($item->getQuiz()->getPreguntas() as $key => $p){
          $preguntas[$p->getId()] = $p->getId();
        }

        $preguntasResueltas = $this->getPreguntasResultas($quizUsuario["quizUsuario"]);
        $quiz = $quizUsuario["quizItem"];

        if(count($preguntas) === count($preguntasResueltas)){
          return $this->render('Front/respuestas.html.twig', array(
            "curso" => $curso,
            "modulo" => $modulo,
            "item" => $item,
            "item_id" => $item->getId(),
            "quiz" => $preguntasResueltas
          ));
        }

        //$pregunta = null;

        $preguntaActual = 0;
        if(null == $pregunta){
          $preguntaActual = current($preguntas);
          $siguientePregunta = next($preguntas);

          foreach($preguntasResueltas as $p){
            if($p->getPreguntas()->getId() === $preguntaActual){

              unset($preguntas[$preguntaActual]);

              foreach($preguntas as $x){

                if($x != $p->getPreguntas()->getId()){
                  return $this->redirect($this->generateUrl('item_quiz', array(
                    'curso' => $curso->getId(),
                    'modulo'=> $modulo->getId(),
                    'item' => $item->getId(),
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
                    return $this->redirect($this->generateUrl('item_quiz', array(
                      'curso' => $curso->getId(),
                      'modulo'=> $modulo->getId(),
                      'item' => $item->getId(),
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
            $em = $this->getDoctrine()->getManager();
          $quiz = $em->getRepository("AppBundle:Admin\Quiz\QuizUsuario")->find($quizUsuario["quizUsuario"]);

          $quizUsuarioDetalle->setQuizes($quiz);
          $formData = $opcionesForm->getData();

          $pregunta = $em->getRepository("AppBundle:Admin\Quiz\Preguntas")->find($preguntaActual);

          $quizUsuarioDetalle->setPreguntas($pregunta);
          $quizUsuarioDetalle->setCalificacion($formData->getOpciones()->getValor());

          $em->persist($quizUsuarioDetalle);
          $em->flush();

          return $this->redirect($this->generateUrl('item_quiz', array(
            'curso' => $curso->getId(),
            'modulo'=> $modulo->getId(),
            'item' => $item->getId(),
            'pregunta' => $siguientePregunta
          )));
        }
        $em = $this->getDoctrine()->getManager();
        $pregunta = $em->getRepository("AppBundle:Admin\Quiz\Preguntas")->find($preguntaActual);

        return $this->render('Front/quiz-respuestas.html.twig', array(
          "curso" => $curso,
          "modulo" => $modulo,
          "item" => $item,
          "item_id" => $item->getId(),
          'pregunta' => $pregunta,
          'opciones_form' => $opcionesForm->createView()
        ));


        // $em = $this->getDoctrine()->getManager();
        //
        // if(!$this->get('app.usuario_curso')->usuarioCursoModuloItem($curso, $modulo, $item)){
        //     $this->get('app.mensajero')->add('info','Usted no tiene acceso a los recursos que solicita');
        //
        //     return $this->redirect($this->generateUrl('front_perfil'));
        // }
        //
        // $curso  = $this->get('app.model.cursos')->curso($curso);
        // $modulo = $this->get('app.model.modulos')->modulo($modulo);
        // $item   = $this->get('app.model.items')->item($item);
        //
        // return $this->render('Front/items/item-video.html.twig', array(
        //   'curso'   => $curso,
        //   'modulo'  => $modulo,
        //   'item'    => $item,
        //   'item_id' => $item->getId()
        // ));

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

}


?>
