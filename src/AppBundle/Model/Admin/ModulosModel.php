<?php

namespace AppBundle\Model\Admin;

use Doctrine\ORM\EntityManager;

class ModulosModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function modulo($modulo)
    {
        $modulo = $this->em->getRepository('AppBundle:Admin\Modulos\Modulos')->find($modulo);
        return $modulo;
    }
}

?>
