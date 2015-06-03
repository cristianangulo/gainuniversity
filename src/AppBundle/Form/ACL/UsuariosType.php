<?php

namespace AppBundle\Form\ACL;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuariosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sendMail', 'checkbox', array(
              'label' => 'Notificar al usuario registrado',
              'mapped' => false
            ))
            ->add('nombre')
            ->add('username')
            ->add('salt','hidden')
            ->add('email')
            ->add('password','repeated', array(
              'type' => 'password',
              'invalid_message' => 'The password fields must match.',
              'options' => array('attr' => array('class' => 'password-field')),
              'required' => true,
              'first_options'  => array('label' => 'Password'),
              'second_options' => array('label' => 'Repeat Password'),
            ))
            // ->add('isActive', 'checkbox', array(
            //   'required' => false,
            //   'label' => 'Usuario activo'
            // ))
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
            'data_class' => 'AppBundle\Entity\ACL\Usuarios',
            'validation_groups' => array('registro_usuario'),
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
