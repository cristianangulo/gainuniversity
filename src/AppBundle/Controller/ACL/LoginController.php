<?php

namespace AppBundle\Controller\ACL;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\ACL\Usuarios;
use AppBundle\Form\ACL\UsuariosLoginType;

class LoginController extends Controller
{

  public function loginAction(Request $request)
  {
    $session = $request->getSession();

    // get the login error if there is one
    if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
      $error = $request->attributes->get(
        SecurityContext::AUTHENTICATION_ERROR
      );
    }else{
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }

    $usuario = new Usuarios();

    $usuarioForm = $this->createForm(new UsuariosLoginType(), $usuario);

    return $this->render('ACL/login.html.twig', array(
      'last_username' => $session->get(SecurityContext::LAST_USERNAME),
      'error'         => $error,
      'usuario_form'   => $usuarioForm->createView()
      )

    );
  }
}
