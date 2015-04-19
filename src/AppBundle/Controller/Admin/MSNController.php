<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Admin\MSN;
use AppBundle\Form\Admin\MSN\MSNType;

use AppBundle\Entity\Admin\MensajesRespuestas;

/**
 * MSN controller.
 *
 */
class MSNController extends Controller
{

  public function msnAdminAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $msnNoContestados = $em->getRepository('AppBundle:Admin\MSN')->MSNNoContestados();

    $msnContestados = $em->getRepository('AppBundle:Admin\MensajesRespuestas')->findAll();

    return $this->render("Admin/MSN/index.html.twig", array(
      'msn_no_contestados' => $msnNoContestados,
      'msn_contestados' => $msnContestados
    ));
  }

  public function msnAction(Request $request)
  {

    $em = $this->getDoctrine()->getEntityManager();

    $msn = new MSN();

    $usuario = $this->getUser()->getId();

    $mensajesUsuario = $em->getRepository('AppBundle:Admin\MensajesRespuestas')->MensajesUsuario($usuario);

    $msnNoContestados = $em->getRepository('AppBundle:Admin\MSN')->MSNNoContestadosUsuario($usuario);

    $msnForm = $this->createForm(new MSNType(), $msn);

    $msnForm->handleRequest($request);

    if($msnForm->isValid()){
      $usuario = $em->getRepository('AppBundle:ACL\Usuarios')->find($usuario);
      $msn->setUsuarios($usuario);
      $em->persist($msn);
      $em->flush();
      return $this->redirect($this->generateUrl('front_msn'));
    }

    return $this->render("Admin/MSN/msn.html.twig", array(
      'msn_form' => $msnForm->createView(),
      'mensajes' => $mensajesUsuario,
      'msn_no_contestados' => $msnNoContestados
    ));
  }

  public function msnResponderAction($id, Request $request)
  {

    $em = $this->getDoctrine()->getEntityManager();
    $mensaje = $em->getRepository("AppBundle:Admin\MSN")->find($id);
    $respuesta = $em->getRepository("AppBundle:Admin\MensajesRespuestas")->findMensajeRespuesta($id);

    if($mensaje->getEstado() == 1){

      return $this->render("Admin/MSN/msn-respondido.html.twig", array(
        'mensaje' => $mensaje,
        'respuesta' => $respuesta->getRespuestas()
      ));
    }

    $msn = new MSN();
    $msnForm = $this->createForm(new MSNType(), $msn);

    $msnForm->handleRequest($request);

    if($msnForm->isValid()){

      $usuario = $em->getRepository('AppBundle:ACL\Usuarios')->find($this->getUser()->getId());
      $msn->setUsuarios($usuario);
      $msn->setEstado(1);
      $em->persist($msn);

      $mensajeRespuesta = new MensajesRespuestas();
      $mensajeRespuesta->setMensajes($mensaje);
      $mensajeRespuesta->setRespuestas($msn);
      $em->persist($mensajeRespuesta);

      $mensaje->setEstado(1);

      $em->flush();

      return $this->redirect($this->generateUrl('admin_msn_responder', array('id' => $mensaje->getId())));
    }

    return $this->render("Admin/MSN/msn-responder.html.twig", array(
      'mensaje' => $mensaje,
      'msn_form' => $msnForm->createView()
    ));
  }

}


?>
