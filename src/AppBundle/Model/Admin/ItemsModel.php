<?php

namespace AppBundle\Model\Admin;

use Doctrine\ORM\EntityManager;

class ItemsModel
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function item($item)
    {
        $item = $this->em->getRepository('AppBundle:Admin\Items\Items')->find($item);
        return $item;
    }

    public function comentarios($curso, $modulo, $item)
    {
        $comentarios = $this->em->getRepository('AppBundle:Front\ComentariosItems')->findComentariosItems($curso, $modulo, $item);

        return $comentarios;
    }
}

?>
