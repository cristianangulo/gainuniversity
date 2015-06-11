<?php

namespace AppBundle\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Front\ComentariosItems;
use AppBundle\Form\Front\ComentariosItemsType;


class ItemForoController extends Controller
{

    public function itemForoAction($curso, $modulo, $item, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if(!$this->get('app.usuario_curso')->usuarioCursoModuloItem($curso, $modulo, $item)){
            $this->get('app.mensajero')->add('info','Usted no tiene acceso a los recursos que solicita');

            return $this->redirect($this->generateUrl('front_perfil'));
        }

        $curso  = $this->get('app.model.cursos')->curso($curso);
        $modulo = $this->get('app.model.modulos')->modulo($modulo);
        $item   = $this->get('app.model.items')->item($item);

        $comentarios = $this->get('app.model.items')->comentarios($curso->getId(), $modulo->getId(), $item->getId());

        $comentariosItems = new ComentariosItems();
        $comentariosForm = $this->createForm(new ComentariosItemsType(), $comentariosItems);

        $comentariosForm->handleRequest($request);

        if($comentariosForm->isValid()){

          $usuario = $this->get('app.model.usuarios')->usuario($this->getUser()->getId());

          $comentariosItems->setUsuarios($usuario);
          $comentariosItems->setCursos($curso);
          $comentariosItems->setModulos($modulo);
          $comentariosItems->setItems($item);

          $em->persist($comentariosItems);
          $em->flush();

          $this->get('app.mensajero')->add('info','Haz hecho un nuevo comentario');
          return $this->redirect($this->generateUrl($item->getTipo()->getSlug(), array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'item' => $item->getId())));

        }

        return $this->render('Front/items/item-foro.html.twig', array(
          'curso'   => $curso,
          'modulo'  => $modulo,
          'item'    => $item,
          'item_id' => $item->getId(),
          'comentarios_item' => $comentarios,
          'comentarios_form' => $comentariosForm->createView()
        ));

    }

    public function eliminarComentarioAction($curso, $modulo, $item, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $curso  = $this->get('app.model.cursos')->curso($curso);
        $modulo = $this->get('app.model.modulos')->modulo($modulo);
        $item   = $this->get('app.model.items')->item($item);

        $comentario = $em->getRepository('AppBundle:Front\ComentariosItems')->find($id);

        $em->remove($comentario);
        $em->flush();
        $this->get('app.mensajero')->add('info','Se ha eliminado un comentario');
        return $this->redirect($this->generateUrl($item->getTipo()->getSlug(), array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'item' => $item->getId())));
    }

}


?>
