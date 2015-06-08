<?php

namespace AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @ModulosCurso
 */
class ModulosCursoListener
{

  protected $logger;

  function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }

  public function onKernelRequest(GetResponseEvent $event)
  {
      if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
          $this->logger->info('************ModulosCurso está escribiendo');
      }


  }
}

?>
