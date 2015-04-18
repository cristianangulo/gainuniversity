<?php

namespace AppBundle\Controller\ACL;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use ACL\ACLBundle\Entity\Usuarios;
use ACL\ACLBundle\Form\RegistroUsuariosType;

class RegistroCuentaController extends Controller
{
  public function registroAction(Request $request)
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

      $entity->setRoles($role);
      $entity->setUsername($formData->getEmail());
      $entity->setIsActive(0);
      $entity->setActivado(0);
      $em->persist($entity);
      $em->flush();

      $message = \Swift_Message::newInstance()
        ->setContentType("text/html")
        ->setSubject('Activar su cuenta')
        ->setFrom(array("no-reply@gainuniversity.com" => "gainuniversity.com"))
        ->setTo($entity->getEmail())
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

    if($entity->getActivado()==0){
      $entity->setIsActive(1);
      $entity->setActivado(1);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('login'));
  }
}
