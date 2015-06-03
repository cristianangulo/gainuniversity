<?php

namespace AppBundle\Form\ACL\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\Form\ACL\UsuariosPasswordType;


class UsuariosSubscriber implements EventSubscriberInterface
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

        // Cmprueba si el objeto está creado

        if (!$data->getId()) {
            $form->add('sendMail', 'checkbox', array(
              'label' => 'Notificar al usuario registrado',
              'mapped' => false
            ))
            ->add('password', new UsuariosPasswordType(), array(
              'label' => false)
            );
        }else{
            $form->add('isActive', 'checkbox', array(
                'required' => false,
                'label' => 'Usuario activo'
            ));
        }
    }
}

?>
