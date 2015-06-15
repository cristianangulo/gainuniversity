<?php

namespace AppBundle\Form\Admin\Modulos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModulosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modulo')
            ->add('mensajeMail','textarea', array(
              'attr' => array('rows' => '10'),
            ))
            ->add('descripcion','textarea', array(
              'attr' => array('rows' => '10'),
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\Modulos\Modulos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'modulo_items';
    }
}
