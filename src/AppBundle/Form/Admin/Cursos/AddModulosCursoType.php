<?php

namespace AppBundle\Form\Admin\Cursos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\Admin\Cursos\EventListener\CursoModulosPosicionSubscriber;


class AddModulosCursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modulos', 'entity', array(
              'class' => 'AppBundle:Admin\Modulos\Modulos',
              'property' => 'modulo',
              'empty_value' => "Seleccione",
              'label' => 'Módulos'
            ))
        ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\Cursos\CursoModulos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'add_modulos_curso';
    }
}
