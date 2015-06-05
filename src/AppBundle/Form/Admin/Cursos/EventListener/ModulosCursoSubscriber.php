<?php

namespace AppBundle\Form\Admin\Cursos\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use AppBundle\Form\Admin\Cursos\CursoModulosType;

class ModulosCursoSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        if ($data->getId()) {
            $form->add('modulos', 'collection', array(
              'type' => new CursoModulosType(),
              'by_reference' => false,
              'allow_add' => true,
              'allow_delete' => true
            ));
        }
    }
}

?>
