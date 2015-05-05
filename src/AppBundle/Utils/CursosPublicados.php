<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;

class CursosPublicados
{
  private $em;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function getCursos()
  {

  }
}

 ?>
