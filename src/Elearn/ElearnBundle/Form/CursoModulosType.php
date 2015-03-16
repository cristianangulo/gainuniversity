<?php

namespace Elearn\ElearnBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CursoModulosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cursos', 'hidden')
            ->add('modulos', 'entity', array(
              'class' => 'ElearnBundle:Modulos',
              'property' => 'modulo',
              'empty_value' => "Seleccione",
              'label' => 'Agregue módulos a este curso'
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elearn\ElearnBundle\Entity\CursoModulos'
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
