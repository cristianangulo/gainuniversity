<?php

namespace AppBundle\Controller\ACL;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Elearn\ElearnBundle\Entity\CursoUsuarios;

class RegistroCursoController extends Controller
{
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
