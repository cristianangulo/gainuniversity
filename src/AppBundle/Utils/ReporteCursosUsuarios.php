<?php

namespace AppBundle\Utils;

use AppBundle\Model\Admin\CursosModel;
/**
 *
 */
class ReporteCursosUsuarios
{
    private $cursos;

    function __construct(CursosModel $cursos)
    {
        $this->cursos = $cursos;
    }

    public function cursoUsuarios($curso)
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

            for($i = 0; $i<count($curso->getModulos()); $i++){

                $registro['usuarios'][$usuario->getId()]['modulos'][$i+1] = $this->darFecha($fecha,($registro['temporalidad']*$i));

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
