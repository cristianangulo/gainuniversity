<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ItemAudioController extends Controller
{

    public function itemAudioAction($curso, $modulo, $item)
    {

        return new Response('Audio');

    }

}


?>
