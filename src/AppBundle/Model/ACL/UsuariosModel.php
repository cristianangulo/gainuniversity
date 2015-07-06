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

    public function usuarios()
    {
        $usuarios = $this->em->getRepository('AppBundle:ACL\Usuarios')->findAll();
        return $usuarios;
    }

    public function cursoUsuario($curso, $usuario)
    {
        $usuarioCurso = $this->em->getRepository('AppBundle:Admin\Cursos\CursoUsuarios')->registroCursoUsuario($curso, $usuario);

        return $usuarioCurso;
    }

    public function nombreDiploma($model, $form)
    {
        $nombre = $form->get('nombre')->getData();

        $model->setNombre($nombre);
        $model->setFechaDiploma(new \Datetime("now"));

        $this->em->persist($model);
        $this->em->flush();
    }
}

?>
