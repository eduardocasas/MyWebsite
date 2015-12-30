<?php

namespace AppBundle\Form\Type\blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleExtendType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', 'textarea', ['label' => 'Contenido:', 'required' => false]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\ArticleExtend']);
    }

    public function getName()
    {
        return 'article_extend_form';
    }

}
