<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class ItemForoController extends Controller
{

    public function itemForoAction($curso, $modulo, $item)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$this->get('app.usuario_curso')->usuarioCursoModuloItem($curso, $modulo, $item)){
            $this->get('app.mensajero')->add('info','Usted no tiene acceso a los recursos que solicita');

            return $this->redirect($this->generateUrl('front_perfil'));
        }

        $curso  = $this->get('app.model.cursos')->curso($curso);
        $modulo = $this->get('app.model.modulos')->modulo($modulo);
        $item   = $this->get('app.model.items')->item($item);

        return $this->render('Front/items/item-audio.html.twig', array(
          'curso'   => $curso,
          'modulo'  => $modulo,
          'item'    => $item,
          'item_id' => $item->getId()
        ));

    }

}


?>
