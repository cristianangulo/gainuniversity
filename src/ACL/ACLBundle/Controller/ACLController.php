<?php

namespace ACL\ACLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use ACL\ACLBundle\Entity\User;

use ACL\ACLBundle\Entity\Usuarios;
use ACL\ACLBundle\Form\RegistroUsuariosType;

class ACLController extends Controller
{
  public function indexAction($name)
  {
    return $this->render('ACLBundle:Default:index.html.twig', array('name' => $name));
  }

  public function newAction()
  {
    $user = new User();

    $user->setUsername("cristianangulonova");

    $factory = $this->get('security.encoder_factory');
    $encoder = $factory->getEncoder($user);

    $user->setPassword($encoder->encodePassword('foo', $user->getSalt()));
    $user->setEmail("cristianangulonova@gmail.com");

    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();

    return new Response('Se ha creado el usuario id: '.$user->getId());
  }

  public function perfilAction()
  {
    $user = $this->get('security.context')->getToken()->getUser();

    return $this->render('ACLBundle:ACL:perfil.html.twig');
  }

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

  return $this->render(
  'ACLBundle:ACL:login.html.twig',
  array(
    // last username entered by the user
    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
    'error'         => $error,
    )
  );
  }

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

      return $this->render('ACLBundle:ACL:mensaje-recuperar.html.twig');
    }

    return $this->render('ACLBundle:ACL:recuperar.html.twig', array(
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

    return $this->render('ACLBundle:ACL:recuperar-pass.html.twig', array(
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

  public function noActivoAction()
  {
    return new Response("Cuenta no activa");
  }

  public function registroAction($orden = null, $curso = null, Request $request)
  {
    $entity = new Usuarios();

    $registroForm = $this->createForm(new RegistroUsuariosType(), $entity);

    $registroForm->handleRequest($request);

    if($registroForm->isValid()){

      $formData = $registroForm->getData();

      $em = $this->getDoctrine()->getManager();

      $role = $em->getRepository("ACLBundle:Roles")->find(2);

      $factory = $this->get('security.encoder_factory');
      $encoder = $factory->getEncoder($entity);
      $formData = $registroForm->getData();
      $entity->setPassword($encoder->encodePassword($formData->getPassword(), $entity->getSalt()));

      $entity->getRoles($role);
      $entity->setUsername($formData->getEmail());
      $entity->setIsActive(0);
      $em->persist($entity);
      $em->flush();

      $message = \Swift_Message::newInstance()     // we create a new instance of the Swift_Message class
        ->setContentType("text/html")
        ->setSubject('Activar su cuenta')     // we configure the title
        ->setFrom(array("no-reply@gainuniversity.com" => "gainuniversity.com"))     // we configure the sender
        ->setTo($entity->getEmail())     // we configure the recipient
        ->setBody($this->renderView(
          "ACLBundle:ACL:mail-registro.html.twig", array(
            'entity' => $entity
          ))
        );

      $this->get('mailer')->send($message);

      return $this->render('ACLBundle:ACL:mensaje-registro.html.twig');
    }

    return $this->render('ACLBundle:ACL:registro.html.twig', array(
      'registro_form' => $registroForm->createView()
    ));
  }

  public function activarCuentaAction($salt)
  {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('ACLBundle:Usuarios')->findOneBySalt($salt);

    if (!$entity) {
        throw $this->createNotFoundException('Unable to find Usuarios entity.');
    }

    $entity->setIsActive(1);
    $em->flush();

    return $this->redirect($this->generateUrl('login'));
  }
}
