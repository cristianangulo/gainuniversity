<?php

namespace ACL\ACLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use ACL\ACLBundle\Entity\User;

use ACL\ACLBundle\Entity\Usuarios;
use ACL\ACLBundle\Form\RegistroUsuariosType;

use ACL\ACLBundle\Entity\UsuariosRoles;

use Elearn\ElearnBundle\Entity\CursoUsuarios;

class ACLController extends Controller
{
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

      $entity->setRoles($role);
      $entity->setUsername($formData->getEmail());
      $entity->setIsActive(0);
      $entity->setActivado(0);
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

    if($entity->getActivado()==0){
      $entity->setIsActive(1);
      $entity->setActivado(1);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('login'));
  }

  public function registroCursoAction($id, $sku)
  {


    $em = $this->getDoctrine()->getManager();

    //Averiguamos el curso con el Salt enviado desde el correo del cliente
    $curso = $em->getRepository('ElearnBundle:Cursos')->findOneBySku($sku);

    if (!$curso) {
        throw $this->createNotFoundException('Este curso no existe.');
    }

    // Conexión con el Servicio
    $cliente = new \nusoap_client($this->container->getParameter('wsdl'));

    // Pasamos los datos al Servicio
    $orden = array(
      'orderId' => $id,
      'sku' => $curso->getSku()
    );

    $conexion = $cliente->call("OrderStatSrv.getStat", $orden);

    // Si el valor de status es igual a 0 se puede registrar el usuario-curso

    //$conexion["status"] = 0;

    if($conexion["status"] == 0){
      $user = $this->getUser();

      // Se genera una consulta preguntando si la relación que se pretente hacer ya existe
      $cursoUsuario = $em->getRepository('ElearnBundle:CursoUsuarios');

      $consulta = $cursoUsuario->createQueryBuilder('c')
        ->where('c.curso = :curso')
        ->andWhere('c.usuario = :usuario')
        ->setParameter('curso', $curso->getId())
        ->setParameter('usuario', $user->getId())
        ->getQuery()
        ->getResult();

      // Si la consulta no existe se genera el registro
      if(!$consulta){
        $cursoUsuario = new CursoUsuarios();

        $em = $this->getDoctrine()->getManager();
        //$curso = $em->getRepository('ElearnBundle:Cursos')->find(2);
        $usuario = $em->getRepository('ACLBundle:Usuarios')->find($user->getId());

        $cursoUsuario->setCurso($curso);
        $cursoUsuario->setUsuario($usuario);

        $em->persist($cursoUsuario);
        $em->flush();

        return $this->redirect($this->generateUrl('front_perfil'));
      }

      return $this->redirect($this->generateUrl('front_perfil'));

    }

    return $this->redirect($this->generateUrl('front_perfil'));

  }
}
