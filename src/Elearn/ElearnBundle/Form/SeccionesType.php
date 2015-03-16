<?php

namespace Elearn\ElearnBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elearn\ElearnBundle\Form\EventListener\AddMultimediaFieldSubscriber;

class SeccionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', 'entity', array(
              'class' => 'ElearnBundle:TipoSeccion',
              'property' => 'tipo_seccion',
            ))
            ->add('seccion','text',array(
              'label' => 'Ítem'
            ))
            ->add('descripcion');

        $builder->addEventSubscriber(new AddMultimediaFieldSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elearn\ElearnBundle\Entity\Secciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearn_elearnbundle_secciones';
    }
}
