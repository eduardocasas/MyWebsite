<?php

namespace AppBundle\Form\Type\Blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextareaType::class, [
            'attr' => ['placeholder' => 'comments.form.placeholder'],
            'label' => false,
            'required' => true,
        ]);
    }

    public function getName()
    {
        return 'comment_form';
    }
}
