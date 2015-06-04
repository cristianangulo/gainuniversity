<?php

namespace AppBundle\Form\Admin\Modulos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddItemsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secciones', 'entity', array(
              'class' => 'AppBundle:Admin\Items\Items',
              'property' => 'seccion',
              'empty_value' => 'Seleccione',
              'label' => 'Ítems'
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\Modulos\ModuloItems'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'add_items_modulo';
    }
}
