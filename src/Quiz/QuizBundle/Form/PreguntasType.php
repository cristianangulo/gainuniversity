<?php

namespace Quiz\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Quiz\QuizBundle\Form\EventListener\PreguntasPosicionSubscriber;

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
            //->add('quiz')
        ;

        $builder->addEventSubscriber(new PreguntasPosicionSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Quiz\QuizBundle\Entity\Preguntas'
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
