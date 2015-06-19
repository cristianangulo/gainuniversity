<?php

namespace AppBundle\Utils;
use AppBundle\Utils\ReporteCursosUsuarios;
use AppBundle\Utils\Cartero;

/**
 *
 */
class ModulosLiberados
{
    private $reporte;
    private $cartero

    function __construct(ReporteCursosUsuarios $reporte, Cartero $cartero)
    {
        $this->reporte = $reporte;
        $this->cartero = $cartero;
    }

    public function send()
    {
        return count($this->reporte->modulosLiberados());
    }


}


?>
