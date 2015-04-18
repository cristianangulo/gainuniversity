<?php

namespace AppBundle\Form\Admin\Items\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddMultimediaFieldSubscriber implements EventSubscriberInterface
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
          $form->add('tipo', 'entity', array(
            'class' => 'AppBundle:Admin\Items\TipoItem',
            'property' => 'tipo_seccion',
            'disabled' => true
          ));

          if($data->getTipo()->getId()==1 || $data->getTipo()->getId()==4 || $data->getTipo()->getId()==6){
            $form->add('multimedia', 'text', array('label' => 'Multimedia'));
          }

          if($data->getTipo()->getId()==3){

            if($data->getPath()==""){
              $form->add('file', null, array(
                'label' => 'El archivo debe pesar hasta 10M'
              ));
            }
          }

          if($data->getTipo()->getId()==5){
            $form->add('quiz', 'entity', array(
              'class' => 'QuizBundle:Quiz',
              'property' => 'quiz',
              'empty_value' => 'Seleccione',
              'label' => 'Multimedia'
              ));
          }

        }
    }
}


?>
