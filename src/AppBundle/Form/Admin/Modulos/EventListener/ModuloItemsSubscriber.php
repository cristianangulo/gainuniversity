<?php

namespace AppBundle\Form\Admin\Modulos\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ModuloItemsSubscriber implements EventSubscriberInterface
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
          $choices = array();

          for($i = 0; $i <count($data->getModulos()->getSecciones()); $i++){
            $choices[$i + 1] = $i + 1;
          }

          $form->add('posicion', 'choice', array(
            'expanded' => false,
            'choices' => $choices
          ));
        }
    }
}


?>
