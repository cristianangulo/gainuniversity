<?php

namespace AppBundle\Utils;

class FechaDiploma
{

    public function fecha($fecha)
    {
        $fecha = date_format($fecha, 'd-m-Y');

        $fecha = explode('-', $fecha);

        $mes = $this->getMes($fecha[1]);

        return "Este día, ". $fecha[0].' de '.$mes.' de '.$fecha[2];
    }

    public function getMes($mes)
    {
        switch ($mes[1]) {
            case 1:
                return 'enero';
                break;
            case 2:
                return "febrero";
            case 3:
                return "marzo";
            case 4:
                return 'abril';
                break;
            case 5:
                return "mayo";
            case 6:
                return "junio";
            case 7:
                return 'julio';
                break;
            case 8:
                return "agosto";
            case 9:
                return "septiembre";
            case 10:
                return 'octubre';
                break;
            case 11:
                return "noviembre";
            case 12:
                return "diciembre";
            default:
                return 'Este mes no existe';
                break;
        }

    }

}


?>
