<?php

namespace AppBundle\Form\Type\Blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleExtendType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', TextareaType::class, [
            'label' => 'Contenido:',
            'required' => false,
            'translation_domain' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ArticleExtend',
        ]);
    }

    public function getName()
    {
        return 'article_extend_form';
    }
}
