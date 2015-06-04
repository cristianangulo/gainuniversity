<?php

namespace AppBundle\Utils;

/**
 * Clase (capa) encargada de abstraer el envío de datos vía email en la aplicación
 */
class Cartero
{

    private $contentType;
    private $subject = 'Gain University';
    private $from = array("no-reply@gainuniversity.com" => "gainuniversity.com");
    private $mensajero;
    private $to;
    private $body;

    public function __construct(\Swift_Mailer $mensajero)
    {
      $this->mensajero = $mensajero;
      $this->contentType = 'text/html';
      $this->subject = 'Gain University';
      $this->from = array("no-reply@gainuniversity.com" => "gainuniversity.com");
    }

    public function msn($mail, $body, $subject = false)
    {
      $message = \Swift_Message::newInstance()
        ->setContentType($this->contentType)
        ->setSubject($this->subject = $subject)
        ->setFrom($this->from)
        ->setTo($mail)
        ->setBody($body);

      return $this->mensajero->send($message);
    }

}


?>
