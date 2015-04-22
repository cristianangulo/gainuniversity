<?php

namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManager;

class Temporalidad
{
    protected $em;
    protected $security;

    public function __construct(SecurityContext $security, EntityManager $em)
    {
      $this->em = $em;
      $this->security = $security;
    }

    public function getModulos($curso)
    {
        $user = $this->security->getToken()->getUser();

        if(!$this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')){

          $registroUsuario = $this->em->getRepository('AppBundle:Admin\Cursos\CursoUsuarios')->registroCursoUsuario($curso->getId(), $user->getId());

          $fechaDePublicacion = ($curso->getFechaPublicacion() < $registroUsuario->getFechaRegistro()) ? $registroUsuario->getFechaRegistro() : $curso->getFechaPublicacion();

          $intervalo = $fechaDePublicacion->diff(new \DateTime('now'))->format('%a');

          $temporalidadCurso = $curso->getTemporalidad();

          $formaPublicacion = 0;

          switch($temporalidadCurso){
            case 1:
              $formaPublicacion = 1;
              break;
            case 2:
              $formaPublicacion = 7;
              break;
            case 3:
              $formaPublicacion = 14;
          };

          $cantidadModulos = ($intervalo / $formaPublicacion + 1);

          $cantidadModulos = ($cantidadModulos > count($curso->getModulos() )) ? count($curso->getModulos()) : $cantidadModulos;

          $modulos = [];
          foreach($curso->getModulos() as $modulo => $key){
            $modulos[$modulo] = $key->getModulos()->getId();
          }

          $modulosConAcceso = [];

          for($i = 0; $i < $cantidadModulos; $i++){
            $modulosConAcceso[$modulos[$i]] = $modulos[$i];
          }

          return $modulosConAcceso;
        }

        return count($curso->getModulos());
    }
}
