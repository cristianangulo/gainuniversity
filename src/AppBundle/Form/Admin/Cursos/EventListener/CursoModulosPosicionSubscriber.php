<?php

namespace Elearn\ElearnBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CursoModulosPosicionSubscriber implements EventSubscriberInterface
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

          for($i = 0; $i <count($data->getCursos()->getModulos()); $i++){
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
