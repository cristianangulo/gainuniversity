<?php

namespace Quiz\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioQuizOpcionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calificacion')
            ->add('curso')
            ->add('modulo')
            ->add('item')
            ->add('quiz')
            ->add('opcion')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Quiz\QuizBundle\Entity\UsuarioQuizOpciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quiz_quizbundle_usuarioquizopciones';
    }
}
