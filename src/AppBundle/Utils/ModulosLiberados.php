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
        if(!empty($this->reporte->modulosLiberados())){
            $reporte = array();
            foreach($this->reporte->modulosLiberados() as $u => $m){ // Usuario => Módulo

                $usuario = $this->usuarios->usuario($u);
                $modulo = $this->modulos->modulo($m);

                $reporte[$u] = array(
                    'usuario' => $usuario->getNombre(),
                    'modulo' => $modulo->getModulo()
                );

                $body = $this->twig->render('Admin/Modulos/modulo-liberado.html.twig', array(
                    'nombre' => $usuario->getNombre(),
                    'modulo' => $modulo->getModulo(),
                    'mensaje' => $modulo->getMail()
                ));

                $this->cartero->msn('cristianangulonova@hotmail.com',$body, 'Módulo liberado');
            }

            $body = $this->twig->render('Admin/Modulos/reporte-modulos-liberados.html.twig', array(
                'reporte' => $reporte,

            ));

            $this->cartero->msn('cristianangulonova@hotmail.com',$body, 'Informe de módulos liberados');
        }
    }


}


?>
