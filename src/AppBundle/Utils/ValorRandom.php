<?php

namespace AppBundle\Utils;

class ValorRandom
{

  private $random;

  public function __construct()
  {
    $this->random;
  }

  public function getValor()
  {
    $this->random = sha1(md5(rand(10,99999999)));
    return $this->random;
  }

}


?>
