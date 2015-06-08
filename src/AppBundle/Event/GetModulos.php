<?php


namespace AppBundle\Event;
use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Admin\Modulos\Modulos;
/**
 * GetUserEvent
 *
 */
class GetModulosEvent extends Event
{

  protected $modulo;

  public function __construct(Modulos $modulo)
  {
      $this->modulo = $modulo;
  }

  public function getModulo()
  {
      return $this->modulo;
  }

}
