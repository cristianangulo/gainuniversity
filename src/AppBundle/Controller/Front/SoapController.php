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
        $server = new \SoapServer('http://elearn.loc/hello.wsdl');
        $server->setObject($this->get('hello'));

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $server->handle();
        $response->setContent(ob_get_clean());

        return $response;


    //     function getProd($categoria) {
    //     if ($categoria == "libros") {
    //         return join(",", array(
    //             "El señor de los anillos",
    //             "Los límites de la Fundación",
    //             "The Rails Way"));
    //     }
    //     else {
    //             return "No hay productos de esta categoria";
    //     }
    //     }
    //
    //     $server = new \soap_server();
    // $server->configureWSDL("producto", "urn:producto");
    //
    // $server->register("getProd",
    //     array("categoria" => "xsd:string"),
    //     array("return" => "xsd:string"),
    //     "urn:producto",
    //     "urn:producto#getProd",
    //     "rpc",
    //     "encoded",
    //     "Nos da una lista de productos de cada categoría");
    //
    //     return new Response($server->service("php://input"));

  }

  public function soapRegistroAction()
  {
    try{

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

    //$cliente = new \SoapClient('http://elearn.loc/soap?wsdl', array("trace" => 1, "exception" => 0));

    // $result = $client->checkVat(array(
    //   'countryCode' => 'DK',
    //   'vatNumber' => '47458714'
    // ));

    $result = $cliente->hello('Cristian');

    echo "<pre>";print_r($result);
    exit();

    var_dump($result);
    exit();
}
catch(Exception $e){
    echo $e->getMessage();
}
  }
}
