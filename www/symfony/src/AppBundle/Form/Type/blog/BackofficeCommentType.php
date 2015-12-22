<?php

namespace AppBundle\Form\Type\blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BackofficeCommentType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'active',
            'checkbox',
            ['label' => 'Activo:', 'required' => false]
        )
        ->add(
            'text',
            'textarea', [
                'attr' => [
                    'autofocus' => 'autofocus',
                    'placeholder' => 'comments.form.placeholder'
                ],
                'label' => 'Texto:',
                'required' => true
            ]
        );
    }

    public function getName()
    {
        return 'comment_form';
    }

}
