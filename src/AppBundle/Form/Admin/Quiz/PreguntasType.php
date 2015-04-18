<?php

namespace AppBundle\Form\Admin\Quiz;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\Admin\Quiz\EventListener\PreguntasPosicionSubscriber;

class PreguntasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pregunta')
        ;

        $builder->addEventSubscriber(new PreguntasPosicionSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\Quiz\Preguntas'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quiz_quizbundle_preguntas';
    }
}
