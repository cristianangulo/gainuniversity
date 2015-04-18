<?php

namespace AppBundle\Form\Admin\Quiz;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\Admin\Quiz\EventListener\OpcionesPosicionSubscriber;

class OpcionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('opcion')
            ->add('valor', 'checkbox', array(
              'required'  => false,
            ))
        ;

        $builder->addEventSubscriber(new OpcionesPosicionSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\Quiz\Opciones',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quiz_quizbundle_opciones';
    }
}
