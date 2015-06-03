<?php

namespace AppBundle\Form\ACL;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Form para recuperar la cuenta del usuario
 * Sólo posee el campo @email y desde el controlador envía información a este correo
 * para poder recuperar la cuenta
 */

class RecuperarCuentaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ACL\Usuarios',
            'validation_groups' => array('recuperar_cuenta'),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'recuperar_cuenta';
    }
}
