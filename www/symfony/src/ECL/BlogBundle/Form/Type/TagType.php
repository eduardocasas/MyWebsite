<?php
namespace ECL\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TagType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            array(
                'attr' => array('autofocus' => 'autofocus'),
                'label' => 'Nombre:',
                'required' => true
            )
        )
        ->add(
            'slug',
            'text',
            array('label' => 'Slug:', 'required' => true)
        );
    }

    public function getName()
    {
        return 'tag_form';
    }

}
