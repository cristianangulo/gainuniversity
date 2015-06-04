<?php

namespace AppBundle\Utils;
use Symfony\Component\HttpFoundation\Session\Session;

class Mensajero
{

  private $session;

  public function __construct(Session $session)
  {
    $this->session = $session;
  }

  public function add($tipo, $msn)
  {
      return $this->session->getFlashBag()->add($tipo, $msn);
  }

}



?>
