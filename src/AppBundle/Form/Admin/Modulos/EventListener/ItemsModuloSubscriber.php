<?php

namespace AppBundle\Form\Admin\Modulos\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use AppBundle\Form\Admin\Modulos\ModuloItemsType;

class ItemsModuloSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Informa al despachador que deseas escuchar el evento
        // form.pre_set_data y se debe llamar al método 'preSetData'.
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

            $form->add('secciones', 'collection', array(
              'type' => new ModuloItemsType(),
              'by_reference' => false,
              'allow_add' => true,
              'allow_delete' => true
            ));
        }
    }
}

?>
