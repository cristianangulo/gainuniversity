<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Front\ComentariosItems;
/**
 *
 */
class EliminarMensajeItemController extends Controller
{

  public function eliminarAction($curso, $modulo, $item, $id)
  {
      $em = $this->getDoctrine()->getManager();

      $comentario = $em->getRepository('AppBundle:Front\ComentariosItems')->find($id);

      $em->remove($comentario);
      $em->flush();
      $this->get('app.mensajero')->add('info','Se ha eliminado un comentario');
      return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso, 'modulo' => $modulo, 'item' => $item)));
  }
}


?>
