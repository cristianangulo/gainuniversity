<?php

namespace AppBundle\Model\Admin;

use Doctrine\ORM\EntityManager;

class CursosModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function curso($curso)
    {
        $curso = $this->em->getRepository('AppBundle:Admin\Cursos\Cursos')->find($curso);
        return $curso;
    }
}

?>
