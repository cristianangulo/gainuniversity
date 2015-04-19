<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\ACL\Usuarios;
use AppBundle\Form\Front\PerfilUsuarioType;
use AppBundle\Form\Front\PasswordUsuarioType;

use ACL\ACLBundle\Entity\CursoUsuarios;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\Admin\Quiz\QuizUsuario;
use AppBundle\Entity\Admin\Quiz\QuizUsuarioDetalle;

use Doctrine\ORM\EntityRepository;



class PerfilController extends Controller
{
  public function perfilAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $usuario = $this->get('security.context')->getToken()->getUser();

    $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->find($usuario->getId());

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
}
