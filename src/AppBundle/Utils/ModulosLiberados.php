<?php

namespace AppBundle\Utils;
use AppBundle\Utils\ReporteCursosUsuarios;
use AppBundle\Utils\Cartero;
use AppBundle\Model\ACL\UsuariosModel;
use AppBundle\Model\Admin\ModulosModel;
/**
 *
 */
class ModulosLiberados
{
    private $reporte;
    private $cartero;

    private $usuarios;
    private $modulos;

    private $twig;

    function __construct(ReporteCursosUsuarios $reporte, Cartero $cartero, UsuariosModel $usuarios, ModulosModel $modulos, \Twig_Environment $twig)
    {
        $this->reporte = $reporte;
        $this->cartero = $cartero;

        $this->usuarios = $usuarios;
        $this->modulos = $modulos;

        $this->twig = $twig;
    }

    public function send()
    {
        foreach($this->reporte->modulosLiberados() as $u => $m){ // Usuario => Módulo

            $usuario = $this->usuarios->usuario($u);
            $modulo = $this->modulos->modulo($m);

            $body = $this->twig->render('Admin/Modulos/modulo-liberado.html.twig', array(
                'nombre' => $usuario->getNombre(),
                'modulo' => $modulo
            ));

            $this->cartero->msn('cristianangulonova@hotmail.com',$body);
        }


    }


}


?>
