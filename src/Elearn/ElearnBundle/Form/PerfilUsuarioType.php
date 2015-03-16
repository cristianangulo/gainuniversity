<?php

namespace Elearn\ElearnBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PerfilUsuarioType extends AbstractType
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
            // ->add('password','repeated', array(
            //   'type' => 'password',
            //   'invalid_message' => 'The password fields must match.',
            //   'options' => array('attr' => array('class' => 'password-field')),
            //   'required' => true,
            //   'first_options'  => array('label' => 'Password'),
            //   'second_options' => array('label' => 'Repeat Password'),
            // ))
            ->add('email')
            ->add('submit', 'submit', array(
              'label' => 'Guardar',
              'attr' => array(
                'class' => 'btn btn-primary'
              )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ACL\ACLBundle\Entity\Usuarios'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'perfil_usuario';
    }
}
