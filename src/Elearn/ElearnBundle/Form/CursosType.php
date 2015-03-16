<?php

namespace Elearn\ElearnBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CursosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('temporalidad', 'choice', array(
              'choices' => array(1 => "Diario", 2 => '7 días', 3 => '14 días'),
              'label' => 'Forma de publicación',
              'empty_value' => 'Seleccione'
            ))
            ->add('fechaPublicacion','date', array(
              'input'  => 'datetime',
              'widget' => 'choice',
            ))
            ->add('curso')
            ->add('descripcion')

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elearn\ElearnBundle\Entity\Cursos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearn_elearnbundle_cursos';
    }
}
