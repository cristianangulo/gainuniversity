<?php

namespace AppBundle\Form\ACL;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuariosPerfilType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('username')
            ->add('salt','hidden')
            ->add('email')
            ->add('isActive', 'checkbox', array(
              'required' => false,
              'label' => 'Usuario activo'
            ))
            ->add('roles', 'entity', array(
              'class' => 'AppBundle:ACL\Roles',
              'property' => 'role',
              'expanded' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ACL\Usuarios'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acl_aclbundle_usuarios';
    }
}