<?php

namespace AppBundle\Controller\ACL;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use ACL\ACLBundle\Entity\Usuarios;
use ACL\ACLBundle\Form\RegistroUsuariosType;

class RecuperarCuentaController extends Controller
{

  public function recuperarAction(Request $request)
  {
    $recuperarForm = $this->recuperarForm();

    $recuperarForm->handleRequest($request);

    if($recuperarForm->isValid()){

      $em = $this->getDoctrine()->getManager();

      $email = $recuperarForm->get('email')->getData();

      $usuario = $em->getRepository("ACLBundle:Usuarios")->findOneByEmail($email);

      if(!$usuario){
        return new Response("Este email no existe");
      }

      $random = sha1(md5(rand(10,99999999)));

      $message = \Swift_Message::newInstance()     // we create a new instance of the Swift_Message class
        ->setContentType("text/html")
        ->setSubject('Recuperar cuenta')     // we configure the title
        ->setFrom(array("no-reply@gainuniversity.com" => "gainuniversity.com"))     // we configure the sender
        ->setTo($usuario->getEmail())     // we configure the recipient
        ->setBody($this->renderView(
          "ACLBundle:ACL:mail.html.twig",
            array(
              'nombre' => $usuario->getNombre(),
              'codigo' => $random
          ))
        );

      $this->get('mailer')->send($message);

      $usuario->setCodigo($random);
      $em->flush();

      return $this->render('ACL/mensaje-recuperar.html.twig');
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
        ->add('submit', 'submit', array('label' => 'recuperar', 'attr' => array('class' => 'btn btn-default')))
        ->getForm();

    return $form;
  }

  public function recuperarCuentaAction($codigo, Request $request)
  {
    $recuperarForm = $this->recuperarPassForm();
    $recuperarForm->handleRequest($request);

    $em = $this->getDoctrine()->getManager();
    $usuario = $em->getRepository("ACLBundle:Usuarios")->findOneByCodigo($codigo);

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
