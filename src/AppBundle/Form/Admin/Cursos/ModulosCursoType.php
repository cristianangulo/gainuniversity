<?php

namespace AppBundle\Form\Admin\Cursos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModulosCursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('modulos', 'collection', array(
          'type' => new CursoModulosType(),
          'by_reference' => false,
          'allow_add' => true,
          'allow_delete' => true
        ));
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
        return 'modulos_curso';
    }
}
