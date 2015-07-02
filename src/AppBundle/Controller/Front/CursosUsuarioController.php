<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elearn\ElearnBundle\Entity\ComentariosItems;
use Elearn\ElearnBundle\Form\ComentariosItemsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\ACL\Usuarios;
use Doctrine\ORM\EntityRepository;

class CursosUsuarioController extends Controller
{
  public function cursosAction()
  {
    $em = $this->getDoctrine()->getManager();

    $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->find($this->getUser()->getId());

    $usuarioCursos = $this->get('app.reporte_cursos_usuarios')->fechaLiberarDiplomaCurso($usuario);

    $cursos = $em->getRepository("AppBundle:Admin\Cursos\Cursos")->findCursosPublicados();

    return $this->render('Front/tus-cursos.html.twig', array(
      'usuario' => $usuario,
      'usuarioCursos' => $usuarioCursos,
      'cursos'  => $cursos
    ));
  }

    public function datosDiplomaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->find($this->getUser()->getId());
        
        return $this->render('Front/datos-diploma.html.twig', array(

        ));
    }
}
