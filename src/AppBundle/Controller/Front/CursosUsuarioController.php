<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elearn\ElearnBundle\Entity\ComentariosItems;
use Elearn\ElearnBundle\Form\ComentariosItemsType;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\ACL\Usuarios;
use Doctrine\ORM\EntityRepository;

class CursosUsuarioController extends Controller
{
  public function cursosAction()
  {
    $em = $this->getDoctrine()->getManager();
    $usuario = $this->get('security.context')->getToken()->getUser();

    $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->find($usuario->getId());

    return $this->render('Front/tus-cursos.html.twig', array(
      'usuario' => $usuario
    ));
  }
}
