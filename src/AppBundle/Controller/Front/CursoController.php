<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Front\ComentariosItems;
use AppBundle\Form\Front\ComentariosItemsType;
use Symfony\Component\HttpFoundation\Request;

class CursoController extends Controller
{
  public function cursoAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $curso = $em->getRepository("AppBundle:Admin\Cursos\Cursos")->find($id);

    if (!$curso) {
        throw $this->createNotFoundException(
        'Este curso no existe '.$id
      );
    }

    $modulos = $this->get('temporalidad');

    return $this->render('elearn/curso.html.twig', array(
      "curso" => $curso,
      "modulos_con_acceso" => $modulos->getModulos($curso)
    ));
  }
}
