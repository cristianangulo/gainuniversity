<?php

namespace Elearn\ElearnBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elearn\ElearnBundle\Form\EventListener\ModuloSeccionesPosicionSubscriber;

class ModuloSeccionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secciones', 'entity', array(
              'class' => 'ElearnBundle:Secciones',
              'property' => 'seccion',
              'empty_value' => 'Seleccione'
            ))
            ->add('posicion');
        ;

        $builder->addEventSubscriber(new ModuloSeccionesPosicionSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elearn\ElearnBundle\Entity\ModuloSecciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearn_elearnbundle_modulosecciones';
    }
}
