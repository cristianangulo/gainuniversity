<?php

namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Utils\Mensajero;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Forms;

//use Symfony\Component\Form\FormFactoryInterface;

use AppBundle\Entity\Front\ComentariosItems;
use AppBundle\Form\Front\ComentariosItemsType;

/**
 *
 */
class ItemModuloModel extends Controller
{
    private $em;
    private $twig;
    private $msn;
    private $router;
    protected $security;

    public function __construct(EntityManager $em, \Twig_Environment $twig, Mensajero $msn, Router $router, SecurityContext $security)
    {
        $this->em     = $em;
        $this->twig   = $twig;
        $this->msn    = $msn;
        $this->router = $router;
        $this->security = $security;
    }

    public function getItemModulo($curso, $modulo, $item, $pregunta)
    {
        if(!$this->getCursoModuloItem($curso, $modulo, $item)){
          exit('Error');
          // $this->msn->add('info','Al parecer, el Curso ni el Módulo ni el Ítem están relacionados.');
          //
          // return new RedirectResponse($this->router->generate('front_curso', array('id' => $curso)));
        }

          $curso  = $this->getCurso($curso);
          $modulo = $this->getModulo($modulo);
          $item   = $this->getItem($item);

          switch ($item->getTipo()->getId()) {
            case 1:
                return new Response($this->renderItemAudio($curso, $modulo, $item));
              break;
            case 2:
                return new Response($this->renderItemForo($curso, $modulo, $item));
              break;
            case 3:
                return new Response($this->renderItemPDF($curso, $modulo, $item));
              break;
            case 4:
                return new Response($this->renderItemVideo($curso, $modulo, $item));
            case 5:
                return new Response($this->renderItemQuiz($curso, $modulo, $item));
              break;
            case 6:
                return new Response($this->renderItemAudioDescarga($curso, $modulo, $item));
              break;
            default:
              break;
          }

    }

    protected function getCursoModuloItem($curso, $modulo, $item)
    {
      return $this->em
        ->getRepository('AppBundle:Admin\Cursos\Cursos')
        ->findCursoModuloItem($curso, $modulo, $item);
    }

    protected function getCurso($curso)
    {
        return $this->em->getRepository('AppBundle:Admin\Cursos\Cursos')->find($curso);
    }

    protected function getModulo($modulo)
    {
        return $this->em->getRepository('AppBundle:Admin\Modulos\Modulos')->find($modulo);
    }

    protected function getItem($item)
    {
        return $this->em->getRepository('AppBundle:Admin\Items\Items')->find($item);
    }

    protected function renderItemAudio($curso, $modulo, $item)
    {
      return $this->twig->render('Front/items/item-audio.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId()
      ));
    }

    protected function renderItemForo($curso, $modulo, $item, Request $request = null)
    {
      $comentarios = new ComentariosItems();

      $cursoId = $curso->getId();
      $moduloId = $modulo->getId();
      $itemId = $item->getId();

      $comentariosItem = $this->em->getRepository('AppBundle:Front\ComentariosItems')->findComentariosItems($cursoId, $moduloId, $itemId);

      $formFactory = Forms::createFormFactory();

      $comentariosForm = $formFactory->createBuilder(new ComentariosItemsType(), $comentarios)->getForm();

      $comentariosForm->handleRequest($request);

      if($comentariosForm->isValid()){

        //$usuario = $this->get('security.context')->getToken()->getUser();

        $user = $this->security->getToken()->getUser();

        $usuario = $this->em->getRepository('AppBundle:ACL\Usuarios')->find($user->getId());

        $comentarios->setUsuarios($usuario);
        $comentarios->setCursos($curso);
        $comentarios->setModulos($modulo);
        $comentarios->setItems($item);

        $this->em->persist($comentarios);
        $this->em->flush();

        return new RedirectResponse($this->router->generate('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'item' => $item->getId())));
        //return $this->redirect($this->generateUrl('front_modulo', array('curso' => $curso->getId(), 'modulo' => $modulo->getId(), 'item' => $item->getId())));

      }

      return $this->twig->render('Front/items/item-foro.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId(),
        'comentarios_form' => $comentariosForm->createView(),
        'comentarios_item' => $comentariosItem
        //'comentarios_form' => $comentariosForm->createView()
      ));
    }

    protected function renderItemPDF($curso, $modulo, $item)
    {
      return $this->twig->render('Front/items/item-audio.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId(),

      ));
    }

    protected function renderItemVideo($curso, $modulo, $item)
    {
      return $this->twig->render('Front/items/item-video.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId()
      ));
    }

    protected function renderItemQuiz($curso, $modulo, $item)
    {
      return $this->twig->render('Front/items/item-audio.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId()
      ));
    }

    protected function renderItemAudioDescarga($curso, $modulo, $item)
    {
      return $this->twig->render('Front/items/item-audio.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId()
      ));
    }

}


?>
