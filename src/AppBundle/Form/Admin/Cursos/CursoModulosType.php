<?php

namespace AppBundle\Form\Admin\Cursos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Elearn\ElearnBundle\Form\EventListener\CursoModulosPosicionSubscriber;


class CursoModulosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('cursos', 'hidden')
            ->add('modulos', 'entity', array(
              'class' => 'AppBundle:Admin\Modulos\Modulos',
              'property' => 'modulo',
              'empty_value' => "Seleccione",
              'label' => 'Agregue módulos a este curso'
            ))
            ->add('posicion')
        ;

        $builder->addEventSubscriber(new CursoModulosPosicionSubscriber());

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
        return 'elearn_elearnbundle_cursomodulos';
    }
}
