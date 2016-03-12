<?php

namespace AppBundle\Form\Type\blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BackofficeCommentType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('active', CheckboxType::class, [
            'label' => 'Activo:',
            'required' => false
        ])
        ->add('text', TextareaType::class, [
            'attr' => [
                'autofocus' => 'autofocus',
                'placeholder' => 'comments.form.placeholder'
            ],
            'label' => 'Texto:',
            'required' => true
        ]);
    }

    public function getName()
    {
        return 'comment_form';
    }

}
