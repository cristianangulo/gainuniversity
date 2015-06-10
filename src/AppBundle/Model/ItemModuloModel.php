<?php

namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Utils\Mensajero;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ItemModuloModel
{
    private $em;
    private $twig;
    private $msn;
    private $router;

    public function __construct(EntityManager $em, \Twig_Environment $twig, Mensajero $msn, Router $router)
    {
        $this->em     = $em;
        $this->twig   = $twig;
        $this->msn    = $msn;
        $this->router = $router;
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
                return $this->renderItemAudio($curso, $modulo, $item);
              break;
            case 2:
                return $this->renderItemForo($curso, $modulo, $item);
              break;
            case 3:
                return $this->renderItemPDF($curso, $modulo, $item);
              break;
            case 4:
                return $this->renderItemVideo($curso, $modulo, $item);
            case 5:
                return $this->renderItemQuiz($curso, $modulo, $item);
              break;
            case 6:
                return $this->renderItemAudioDescarga($curso, $modulo, $item);
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

    protected function renderItemForo($curso, $modulo, $item)
    {
      return $this->twig->render('Front/items/item-foro.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId()
      ));
    }

    protected function renderItemPDF($curso, $modulo, $item)
    {
      return $this->twig->render('Front/items/item-audio.html.twig', array(
        'curso'   => $curso,
        'modulo'  => $modulo,
        'item'    => $item,
        'item_id' => $item->getId()
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
