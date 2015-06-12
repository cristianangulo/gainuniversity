<?php

namespace AppBundle\Utils;

use AppBundle\Model\Admin\CursosModel;
use AppBundle\Model\ACL\UsuariosModel;
/**
 *
 */
class ReporteCursosUsuarios
{
    private $cursos;
    private $usuarios;

    function __construct(CursosModel $cursos, $usuarios)
    {
        $this->cursos = $cursos;
        $this->usuarios = $usuarios;
    }


    public function usuario($usuario)
    {
        $usuario = $this->usuarios->usuario($usuario);

        $registro = array();

        foreach($usuario->getCursos() as $curso){

            $registro[$curso->getCursos()->getId()]['curso'] = $curso->getCursos()->getCurso();

            $registro[$curso->getCursos()->getId()]['registro'] = $this->dateFormat($curso->getFechaRegistro());

            $inicioCurso = $curso->getCursos()->getFechaPublicacion();

            if($curso->getCursos()->getFechaPublicacion() < $curso->getFechaRegistro()){
                $inicioCurso = $curso->getFechaRegistro();
            }


            $registro[$curso->getCursos()->getId()]['inicio_curso'] = $this->dateFormat($inicioCurso);

            $intervalo = $inicioCurso->diff(new \DateTime('now'))->format('%a');

            $registro[$curso->getCursos()->getId()]['dias_transcurridos'] = $intervalo;

            $temporalidad = $this->temporalidad($curso->getCursos()->getTemporalidad());

            $cantidadModulos = ($intervalo / $temporalidad + 1);

            $cantidadModulos = ($cantidadModulos > count($curso->getCursos()->getModulos() )) ? count($curso->getCursos()->getModulos()) : floor($cantidadModulos);

            $registro[$curso->getCursos()->getId()]['modulos_hoy'] = $cantidadModulos;

            $fecha = $this->dateFormat($inicioCurso);

            $registro[$curso->getCursos()->getId()]['modulos'] = array();

            foreach($curso->getCursos()->getModulos() as $k => $modulo){
                $registro[$curso->getCursos()->getId()]['modulos'][$modulo->getModulos()->getId()] = $this->darFecha($fecha,($temporalidad*$k));
            }

        }

        return $registro;
    }

    public function cursos()
    {
        $reporte = array();

        foreach($this->cursos->cursos() as $curso){
            $reporte[$curso->getId()] = $this->curso($curso->getId());
        }

        return $reporte;
    }

    public function curso($curso)
    {

        $curso = $this->cursos->curso($curso);

        $publicacionCurso = $curso->getFechaPublicacion();

        $registro = array();
        $registro['curso'] = $curso->getCurso();
        $registro['publicacion'] = $this->dateFormat($curso->getFechaPublicacion());
        $registro['modulos'] = count($curso->getModulos());
        $registro['usuarios_curso'] = count($curso->getUsuarios());
        $registro['temporalidad'] = $this->temporalidad($curso->getTemporalidad());

        $registro['usuarios'] = array();

        foreach($curso->getUsuarios() as $k => $usuario){
            $registro['usuarios'][$usuario->getId()]['nombre'] = $usuario->getUsuarios()->getNombre();
            $registro['usuarios'][$usuario->getId()]['registro'] = $this->dateFormat($usuario->getFechaRegistro());

            $inicioCurso = $curso->getFechaPublicacion();

            if($curso->getFechaPublicacion() < $usuario->getFechaRegistro()){
                $inicioCurso = $usuario->getFechaRegistro();
            }

            $registro['usuarios'][$usuario->getId()]['inicio_curso'] = $this->dateFormat($inicioCurso);

            $intervalo = $inicioCurso->diff(new \DateTime('now'))->format('%a');
            $registro['usuarios'][$usuario->getId()]['dias_transcurridos'] = $intervalo;

            $cantidadModulos = ($intervalo / $registro['temporalidad'] + 1);

            $cantidadModulos = ($cantidadModulos > count($curso->getModulos() )) ? count($curso->getModulos()) : floor($cantidadModulos);

            $registro['usuarios'][$usuario->getId()]['modulos_hoy'] = $cantidadModulos;

            $fecha = $this->dateFormat($inicioCurso);

            $registro['usuarios'][$usuario->getId()]['modulos'] = array();

            foreach($curso->getModulos() as $k => $modulo){
                $registro['usuarios'][$usuario->getId()]['modulos'][$modulo->getId()] = $this->darFecha($fecha,($registro['temporalidad']*$k));
            }

        }

        return $registro;
    }

    protected function dateFormat($date)
    {
        return date_format($date, 'd/m/Y');
    }

    protected function temporalidad($tempo)
    {
        switch($tempo){
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

    protected function darFecha($fecha, $dia)
    {
        list($day,$mon,$year) = explode('/',$fecha);
        return date('d/m/Y',mktime(0,0,0,$mon,$day+$dia,$year));
    }
}


?>
