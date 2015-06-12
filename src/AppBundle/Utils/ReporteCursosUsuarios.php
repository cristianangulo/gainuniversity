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
        $registro['temporalidad'] = $this->tempo($curso->getTemporalidad());

        $registro['usuarios'] = array();

        foreach($curso->getUsuarios() as $k => $usuario){
            $registro['usuarios'][$usuario->getId()]['nombre'] = $usuario->getUsuarios()->getNombre();
            $registro['usuarios'][$usuario->getId()]['registro'] = $this->dateFormat($usuario->getFechaRegistro());
            //$registro['usuarios'][$k]['usuario'] = $usuario->getUsuarios()->getNombre();
        }

        // $temporalidadCurso = $curso->getTemporalidad();
        //
        // $formaPublicacion = 0;
        //
        // switch($temporalidadCurso){
        //   case 1:
        //     $formaPublicacion = 1;
        //     break;
        //   case 2:
        //     $formaPublicacion = 7;
        //     break;
        //   case 3:
        //     $formaPublicacion = 14;
        // };
        //
        // function dameFecha($fecha,$dia)
        // {   list($day,$mon,$year) = explode('/',$fecha);
        //     return date('d/m/Y',mktime(0,0,0,$mon,$day+$dia,$year));
        // }
        // foreach($curso->getUsuarios() as $usuario){
        //     echo "<hr />";
        //     echo $usuario->getUsuarios()->getNombre()."<br />";
        //     $registroUsuarioCurso = date_format($usuario->getFechaRegistro(), 'd/m/Y');
        //
        //     echo $registroUsuarioCurso."<br />";
        //
        //     $fechaInicioCurso = 0;
        //
        //     if($curso->getFechaPublicacion() < $usuario->getFechaRegistro()){
        //       $fechaInicioCurso = $usuario->getFechaRegistro();
        //     }else{
        //       $fechaInicioCurso = $curso->getFechaPublicacion();
        //     }
        //
        //     echo date_format($fechaInicioCurso, 'd/m/Y').'<br />';
        //
        //     $intervalo = $fechaInicioCurso->diff(new \DateTime('now'))->format('%a');
        //
        //     echo 'Días desde el registro: '. $intervalo.'<br />';
        //
        //     $cantidadModulos = ($intervalo / $formaPublicacion + 1);
        //
        //     $cantidadModulos = ($cantidadModulos > count($curso->getModulos() )) ? count($curso->getModulos()) : floor($cantidadModulos);
        //
        //     echo $cantidadModulos.'<br />';
        //
        //     $fecha = date_format($fechaInicioCurso, 'd/m/Y');
        //
        //     for($i = 0; $i<count($curso->getModulos()); $i++){
        //       echo 'Modulo'.($i+1).': '.dameFecha($fecha,($formaPublicacion*$i)).'<br />';
        //     }
        // }

        return $registro;
    }

    protected function dateFormat($date)
    {
        return date_format($date, 'd/m/Y');
    }

    protected function tempo($tempo)
    {
        switch($tempo){
          case 1:
            return $formaPublicacion = 1;
            break;
          case 2:
            return $formaPublicacion = 7;
            break;
          case 3:
            return $formaPublicacion = 14;
        };
    }

    protected function darFecha($fecha, $dia)
    {
        list($day,$mon,$year) = explode('/',$fecha);
        return date('d/m/Y',mktime(0,0,0,$mon,$day+$dia,$year));
    }
}


?>
