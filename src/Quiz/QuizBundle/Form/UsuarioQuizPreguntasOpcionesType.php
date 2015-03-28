<?php

namespace Quiz\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioQuizPreguntasOpcionesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cursos')
            ->add('modulos')
            ->add('items')
            ->add('quizes')
            ->add('preguntas')
            ->add('opciones')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Quiz\QuizBundle\Entity\UsuarioQuizPreguntasOpciones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quiz_quizbundle_usuarioquizpreguntasopciones';
    }
}
