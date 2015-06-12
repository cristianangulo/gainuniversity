<?php

namespace AppBundle\Controller\ACL;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\ACL\Usuarios;
use AppBundle\Form\ACL\RecuperarCuentaType;
use AppBundle\Form\ACL\UsuariosPasswordType;

class RecuperarCuentaController extends Controller
{

  public function recuperarAction(Request $request)
  {

    $usuario = new Usuarios();

    $recuperarForm = $this->createForm(new RecuperarCuentaType(), $usuario);

    $recuperarForm->handleRequest($request);

    if($recuperarForm->isValid()){

      $em = $this->getDoctrine()->getManager();

      $email = $recuperarForm->getData();

      $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->findOneByEmail($email->getEmail());

      $mensaje = 'Se ha enviado un e-mail a '. $email->getEmail() .' con la información necesaria para que puedas activar la cuenta';

      /**
       * Capa de seguridad para evitar envíos de mails
       * de usuarios que no están registrados en la aplicación
       */

      if(!$usuario){

        $this->get('app.mensajero')->add('info', $mensaje);

        return $this->redirect($this->generateUrl('login'));
      }

      $random = $this->get('app.valor_random')->getValor();

      $mail = 'cristianangulonova@hotmail.com';

      $body = $this->renderView("ACL/mail.html.twig",array(
                  'nombre' => $usuario->getNombre(),
                  'codigo' => $random
              ));

      $this->get('app.cartero')->msn($mail, $body, 'Recuperar cuenta');

      $usuario->setCodigo($random);
      $em->flush();

      $this->get('app.mensajero')->add('info', $mensaje);
      return $this->redirect($this->generateUrl('login'));
    }

    return $this->render('ACL/recuperar.html.twig', array(
      'form' => $recuperarForm->createView()
    ));
  }

  private function recuperarForm()
  {
    $form = $this->createFormBuilder()
        ->add('email', 'email', array(
          'label' => '@e-mail'
        ))
        ->getForm();

    return $form;
  }

  public function cambiarPasswordAction($codigo, Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->findOneByCodigo($codigo);

    $recuperarForm = $this->createForm(new UsuariosPasswordType(), $usuario);

    if(!$usuario){
      return $this->redirect($this->generateUrl('login'));
    }

    $recuperarForm->handleRequest($request);

    if($recuperarForm->isValid()){

      $password = $recuperarForm->getData()->getPassword();
      $encoder = $this->get('encoder')->setUserPassword($usuario, $password);
      $usuario->setPassword($encoder);
      $usuario->setCodigo("");
      $em->flush();

      $this->get('session')->getFlashBag()->add('mensaje', 'Se ha cambiado la contraseña. Ingrese a su cuenta');

      return $this->redirect($this->generateUrl('login'));
    }

    return $this->render('ACL/cambiar-password.html.twig', array(
      'form' => $recuperarForm->createView()
    ));
  }
}
