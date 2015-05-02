<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SoapClienteController extends Controller
{
  public function soapClienteAction(Request $request)
  {
    $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

    $cliente = new \SoapClient($baseurl.'/soap?wsdl');

    $userWS = "gain";
    $passWS = "5FZ2Z8QIkA7UTZ4BYkoC==";
    $nombre = "@SoyDonCristian";
    $email = "cristianangulonova@hotmail.com";
    $sku  = "EABR-K14";

    //$usuario = $cliente->registroUsuario($userWS, $passWS, $nombre, $email);

    $api = $this->get('api.elearn.soap');

    $usuario = $api->registroUsuario($userWS, $passWS, $nombre, $email);

    $registro = $api->registroUsuarioCurso($usuario, $sku);
    return new Response("Listo");
  }
}
