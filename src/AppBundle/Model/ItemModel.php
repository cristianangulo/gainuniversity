<?php

namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;
/**
 *
 */
class ItemModel
{
    private $em;
    private $twig;

    public function __construct(EntityManager $em, \Twig_Environment $twig)
    {
        $this->em   = $em;
        $this->twig = $twig;
    }

    public function getItemModulo($curso, $modulo, $item, $pregunta)
    {
        try{
          if(!$this->getCursoModuloItem($curso, $modulo, $item)){
            throw new \Exception('Al parecer, el Curso ni el Módulo ni el Ítem están relacionados.');
          }

          $item = $this->getItem($item);

          switch ($item->getTipo()->getId()) {
            case 1:
              return $this->renderItemAudio();
              break;
            case 2:
              $this->renderItemForo();
            default:
              break;
          }

        }catch(\Exception $e){
          return $e->getMessage();
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

    protected function renderItemAudio()
    {
      return $this->twig->render('Front/items/item-video.html.twig');
    }

}


?>
