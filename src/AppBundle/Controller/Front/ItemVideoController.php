<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ItemVideoController extends Controller
{

    public function itemVideoAction($curso, $modulo, $item)
    {
        $em = $this->getDoctrine()->getManager();

        //echo "<pre>";print_r($this->get('app.reporte_cursos_usuarios')->cursos());exit();
        echo "<pre>";print_r($this->get('app.reporte_cursos_usuarios')->usuario(2));exit();
        //echo "<pre>";print_r($this->get('app.reporte_cursos_usuarios')->curso(1));exit();
        exit();

        if(!$this->get('app.usuario_curso')->usuarioCursoModuloItem($curso, $modulo, $item)){
            $this->get('app.mensajero')->add('info','Usted no tiene acceso a los recursos que solicita');

            return $this->redirect($this->generateUrl('front_perfil'));
        }

        $curso  = $this->get('app.model.cursos')->curso($curso);
        $modulo = $this->get('app.model.modulos')->modulo($modulo);
        $item   = $this->get('app.model.items')->item($item);

        return $this->render('Front/items/item-video.html.twig', array(
          'curso'   => $curso,
          'modulo'  => $modulo,
          'item'    => $item,
          'item_id' => $item->getId()
        ));

    }

}


?>
