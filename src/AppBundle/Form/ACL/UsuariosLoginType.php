<?php

namespace AppBundle\Form\ACL;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\ACL\EventListener\OnLoginSubscriber;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;

class UsuariosLoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = new Session();


        $builder
            ->add('_username', 'text', array(
              'label' => '@mail',
              'attr' => array(
                'placeholder' => 'email@email.com'
              ),
              'data' => $session->get(SecurityContext::LAST_USERNAME)
            ))
            ->add('_password', 'password', array(
              'attr' => array(
                'placeholder' => '**********'
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
            'data_class' => 'AppBundle\Entity\ACL\Usuarios',
            'validation_groups' => array('usuarios_login'),
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        // No se retorna nombre para el Login
        return '';
    }
}
