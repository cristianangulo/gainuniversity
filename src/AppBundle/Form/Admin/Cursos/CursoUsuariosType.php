<?php

namespace Elearn\ElearnBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CursoUsuariosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaRegistro','date', array(
            ))
            ->add('usuario', 'entity', array(
              'class' => 'ACLBundle:Usuarios',
              'property' => 'nombre',
              'empty_value' => 'Seleccione'
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elearn\ElearnBundle\Entity\CursoUsuarios'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearn_elearnbundle_cursousuarios';
    }
}
