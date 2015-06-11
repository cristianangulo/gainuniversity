<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ItemsFrontController extends Controller
{

    public function itemAudioAction($curso, $modulo, $item)
    {

        return new Response('Audio');

    }

    public function itemForoAction($curso, $modulo, $item)
    {

        return new Response('Foro');

    }

    public function itemPDFAction($curso, $modulo, $item)
    {

        return new Response('PDF');

    }

    public function itemVideoAction($curso, $modulo, $item)
    {

        return new Response('Video');

    }

    public function itemQuizAction($curso, $modulo, $item)
    {

        return new Response('Quiz');

    }

    public function itemAudioDownAction($curso, $modulo, $item)
    {

        return new Response('Audio descarga');

    }

    public function pathAction($id)
    {

        return new Response($id);

    }

}


?>
