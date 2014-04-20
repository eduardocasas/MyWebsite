<?php
namespace ECL\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'text',
            'textarea',
            array(
                'attr' => array(
                    'placeholder' => 'comments.form.placeholder'
                ),
                'label' => false,
                'required' => true
            )
        );
    }

    public function getName()
    {
        return 'comment_form';
    }

}
