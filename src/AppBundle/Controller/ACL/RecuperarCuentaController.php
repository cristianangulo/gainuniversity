<?php

namespace AppBundle\Controller\ACL;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use AppBundle\Entity\ACL\Usuarios;
use AppBundle\Form\ACL\RecuperarCuentaEmailType;

class RecuperarCuentaController extends Controller
{

  public function recuperarAction(Request $request)
  {

    $usuario = new Usuarios();

    $recuperarForm = $this->createForm(new RecuperarCuentaEmailType(), $usuario);

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

        $this->get('session')->getFlashBag()->add('mensaje', $mensaje);

        return $this->redirect($this->generateUrl('acl_recuperar'));
      }

      $random = $this->get('app.valor_random')->getValor();

      $mail = 'cristianangulonova@hotmail.com';

      $body = $this->renderView("ACL/mail.html.twig",array(
                  'nombre' => $usuario->getNombre(),
                  'codigo' => $random
              ));

      $this->get('app.mensajero')->mensajero($mail, $body, 'Recuperar cuenta');

      $usuario->setCodigo($random);
      $em->flush();

      $this->get('session')->getFlashBag()->add('mensaje', $mensaje);

      return $this->redirect($this->generateUrl('acl_recuperar'));
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

  public function recuperarCuentaAction($codigo, Request $request)
  {
    $recuperarForm = $this->recuperarPassForm();
    $recuperarForm->handleRequest($request);

    $em = $this->getDoctrine()->getManager();
    $usuario = $em->getRepository("AppBundle:ACL\Usuarios")->findOneByCodigo($codigo);

    if(!$usuario){
      return $this->redirect($this->generateUrl('login'));
    }

    if($recuperarForm->isValid()){
      $password = $recuperarForm->get("password")->getData();

      $factory = $this->get('security.encoder_factory');
      $encoder = $factory->getEncoder($usuario);
      $usuario->setPassword($encoder->encodePassword($password, $usuario->getSalt()));
      $usuario->setCodigo("");
      $em->flush();
      return $this->redirect($this->generateUrl('login'));
    }

    return $this->render('ACL/recuperar-pass.html.twig', array(
      'form' => $recuperarForm->createView()
    ));
  }

  public function recuperarPassForm()
  {
    $form = $this->createFormBuilder()
    ->add('password','repeated', array(
      'type' => 'password',
      'invalid_message' => 'Los password no coinciden',
      'options' => array('attr' => array('class' => 'password-field')),
      'required' => true,
      'first_options'  => array('label' => 'Password'),
      'second_options' => array('label' => 'Repita Password'),
    ))
        ->add('submit', 'submit', array('label' => 'recuperar', 'attr' => array('class' => 'btn btn-default')))
        ->getForm();

    return $form;
  }
}
