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
  public function soapClienteAction()
  {
    $opts = array(
        'http'=>array(
            'user_agent' => 'PHPSoapClient'
            )
        );

    $context = stream_context_create($opts);
    $cliente = new \SoapClient('http://elearn.loc/soap?wsdl',
      array('stream_context' => $context,
         'cache_wsdl' => WSDL_CACHE_NONE,
         "trace" => 1, "exception" => 0
      ));


    // $string = "gain,".$pass.",SoyDonCristian,cristianangulonova@hotmail.com,EABR-K14";
    // $result = $cliente->registroSoap($string);
    $userWS = "gain";
    $passWS = "5FZ2Z8QIkA7UTZ4BYkoC==";
    $nombre = "Cristian Angulo";
    $email = "cristian@gmail.com";
    $sku  = "SKU";

    $usuario = $cliente->registroUsuario($userWS, $passWS, $nombre, $email);

    $registroCurso = $cliente->registroUsuarioCurso($usuario,$sku);

    echo "<pre>";print_r($usuario);
    echo "<pre>";print_r($registroCurso);
    exit();
    var_dump($registro);

    var_dump($registroCurso);
    exit();
    $crearUsuario = $this->get('registro_soap');
    echo $crearUsuario->registroSoap($string);

    exit();
  }
}
