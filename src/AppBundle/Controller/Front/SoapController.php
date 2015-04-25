<?php

namespace AppBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SoapController extends Controller
{
  public function soapAction()
  {
        $server = new \SoapServer('http://elearn.loc/registro.wsdl');
        $server->setObject($this->get('registro_soap'));

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;

  }

  public function soapRegistroAction()
  {
    // $opts = array(
    //     'http'=>array(
    //         'user_agent' => 'PHPSoapClient'
    //         )
    //     );
    //
    // $context = stream_context_create($opts);
    // $cliente = new \SoapClient('http://elearn.loc/soap?wsdl',
    //                          array('stream_context' => $context,
    //                                'cache_wsdl' => WSDL_CACHE_NONE,
    //                                "trace" => 1, "exception" => 0
    //                                ));

    $pass = "5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==";
    $string = "gain,".$pass.",David Cristian,david@gmail.com,sku";
    //$result = $cliente->registroSoap($string);

    $crearUsuario = $this->get('registro_soap');
    echo $crearUsuario->registroSoap($string);
    exit();
  }
}
