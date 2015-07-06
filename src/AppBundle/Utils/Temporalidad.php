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

          $intervalo = $this->intervalo($curso, $user);

          $cantidadModulos = $this->cantidadModulos($intervalo, $curso);

          return $this->modulosConAcceso($curso, $cantidadModulos);
        }

        return $this->modulosConAcceso($curso, count($curso->getModulos()));
    }

    public function intervalo($curso, $user)
    {
      $registroUsuario = $this->em->getRepository('AppBundle:Admin\Cursos\CursoUsuarios')->registroCursoUsuario($curso->getId(), $user->getId());

      $fechaDePublicacion = ($curso->getFechaPublicacion() < $registroUsuario->getFechaRegistro()) ? $registroUsuario->getFechaRegistro() : $curso->getFechaPublicacion();

      $intervalo = $fechaDePublicacion->diff(new \DateTime('now'))->format('%a');

      return $intervalo;
    }

    public function cantidadModulos($intervalo, $curso)
    {
      $temporalidadCurso = $this->temporalidad($curso->getTemporalidad());

      $cantidadModulos = ($intervalo / $temporalidadCurso + 1);

      $cantidadModulos = ($cantidadModulos > count($curso->getModulos() )) ? count($curso->getModulos()) : floor($cantidadModulos);

      return $cantidadModulos;
    }

    public function modulosConAcceso($curso, $cantidadModulos)
    {
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

    public function temporalidad($data)
    {
        switch($data){
          case 1:
            return 1;
            break;
          case 2:
            return 7;
            break;
          case 3:
            return 14;
        };
    }
}
