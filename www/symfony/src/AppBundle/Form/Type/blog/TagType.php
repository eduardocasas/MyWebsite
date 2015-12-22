<?php

namespace AppBundle\Form\Type\blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TagType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
            'attr' => ['autofocus' => 'autofocus'],
            'label' => 'Nombre:',
            'required' => true
        ])
        ->add('slug', 'text', ['label' => 'Slug:', 'required' => true]);
    }

    public function getName()
    {
        return 'tag_form';
    }

}
