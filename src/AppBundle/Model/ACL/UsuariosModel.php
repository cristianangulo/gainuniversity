<?php

namespace AppBundle\Model\ACL;

use Doctrine\ORM\EntityManager;

class UsuariosModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function usuario($usuario)
    {
        $usuario = $this->em->getRepository('AppBundle:ACL\Usuarios')->find($usuario);
        return $usuario;
    }
}

?>
