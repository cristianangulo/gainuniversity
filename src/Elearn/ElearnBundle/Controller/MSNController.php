<?php

namespace Elearn\ElearnBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Elearn\ElearnBundle\Entity\MSN;
use Elearn\ElearnBundle\Form\MSNType;

/**
 * MSN controller.
 *
 */
class MSNController extends Controller
{

  public function msnAction(Request $request)
  {

    $msn = new MSN();
    $msnForm = $this->createForm(new MSNType(), $msn);

    $msnForm->handleRequest($request);

    if($msnForm->isValid()){

      $em = $this->getDoctrine()->getEntityManager();

      $usuario = $em->getRepository('ACLBundle:Usuarios')->find($this->getUser()->getId());
      $msn->setUsuarios($usuario);
      $msn->setEstado(1);
      $em->persist($msn);

      $em->flush();

      exit("Válido");
    }

    return $this->render("ElearnBundle:MSN:msn.html.twig", array(
      'msn_form' => $msnForm->createView()
    ));
  }

}


?>
