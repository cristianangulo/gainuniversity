<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;

/**
 *
 */
class UsuarioCurso
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function usuarioCurso($usuario, $curso)
    {
        return $curso.$usuario;
    }

    public function usuarioCursoModuloItem($curso, $modulo, $item)
    {
        return $this->em
          ->getRepository('AppBundle:Admin\Cursos\Cursos')
          ->findCursoModuloItem($curso, $modulo, $item);
    }
}


?>
