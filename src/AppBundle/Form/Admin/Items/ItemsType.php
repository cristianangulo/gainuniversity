<?php

namespace AppBundle\Form\Admin\Items;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\Admin\Items\EventListener\AddMultimediaFieldSubscriber;

class ItemsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', 'entity', array(
              'class' => 'AppBundle:Admin\Items\TipoItem',
              'property' => 'tipoSeccion',
            ))
            ->add('seccion','text',array(
              'label' => 'Ítem'
            ))
            ->add('descripcion');

        $builder->addEventSubscriber(new AddMultimediaFieldSubscriber());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Admin\Items\Items'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elearn_elearnbundle_secciones';
    }
}
