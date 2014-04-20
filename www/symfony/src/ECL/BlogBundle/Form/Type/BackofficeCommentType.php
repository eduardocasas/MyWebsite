<?php
namespace ECL\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BackofficeCommentType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'active',
            'checkbox',
            array('label' => 'Activo:', 'required' => false)
        )
        ->add(
            'text',
            'textarea',
            array(
                'attr' => array(
                    'autofocus' => 'autofocus',
                    'placeholder' => 'comments.form.placeholder'
                ),
                'label' => 'Texto:',
                'required' => true
            )
        );
    }

    public function getName()
    {
        return 'comment_form';
    }

}
