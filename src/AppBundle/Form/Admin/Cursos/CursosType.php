<?php

namespace AppBundle\Form\Admin\Cursos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\Admin\Cursos\EventListener\CursoModulosSubscriber;

class CursosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('publicado', null, array(
              'required' => false
            ))
            ->add('urlTienda', null, array(
              'required' => false
            ))
            ->add('temporalidad', 'choice', array(
              'choices' => array(1 => "Diario", 2 => '7 días', 3 => '14 días'),
              'label' => 'Forma de publicación',
              'empty_value' => 'Seleccione'
            ))
            ->add('fechaPublicacion','date', array(
              'input'  => 'datetime',
              'widget' => 'choice',
            ))
            ->add('curso')
            ->add('sku', 'text', array(
              'label' => 'Ponga aquí el SKU del curso de tusaludfisicaymental.com'
            ))
            ->add('descripcion')
            //->add('modulos')
        ;

        $builder->addEventSubscriber(new CursoModulosSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\Cursos\Cursos'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearn_elearnbundle_cursos';
    }
}
