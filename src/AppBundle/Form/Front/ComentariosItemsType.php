<?php

namespace AppBundle\Form\Front;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComentariosItemsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comentario')
            ->add('submit', 'submit', array('label' => 'Comente', 'attr' => array('class' => 'btn btn-danger')));
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Front\ComentariosItems'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearn_elearnbundle_comentariositems';
    }
}
