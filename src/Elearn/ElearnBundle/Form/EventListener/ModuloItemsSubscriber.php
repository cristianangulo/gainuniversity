<?php

namespace Elearn\ElearnBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Elearn\ElearnBundle\Form\ModuloSeccionesType;

class ModuloItemsSubscriber implements EventSubscriberInterface
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

        // Durante la creación del formulario setData() es llamado con null como
        // argumento por el constructor FormBuilder. Solo te interesa cuando
        // setData es llamado con un objeto Entity real (ya sea nuevo,
        // o recuperado con Doctrine). Esta declaración 'if' permite evadir
        // la condición null.
        if (null === $data) {
            return;
        }

        // comprueba si el objeto producto es "nuevo"
        if ($data->getId()) {
            $form->add('secciones', 'collection', array(
              'type' => new ModuloSeccionesType(),
              'by_reference' => false,
              'allow_add' => true,
              'allow_delete' => true
            ));
        }
    }
}

?>
