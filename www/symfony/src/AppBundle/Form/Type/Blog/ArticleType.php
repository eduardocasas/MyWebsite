<?php

namespace AppBundle\Form\Type\Blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Article;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('active', CheckboxType::class, [
            'label' => 'Activo:',
            'required' => false,
            'translation_domain' => false,
        ])
        ->add('language', ChoiceType::class, [
            'choices' => [
                'Español' => Article::SPANISH_LANGUAGE,
                'Inglés' => Article::ENGLISH_LANGUAGE,
                'Ambos' => Article::BOTH_LANGUAGE,
            ],
            'label' => 'Idioma:',
            'required' => true,
            'translation_domain' => false,
        ])
        ->add('title', TextType::class, [
            'attr' => ['autofocus' => 'autofocus'],
            'label' => 'Nombre:',
            'required' => true,
            'translation_domain' => false,
        ])
        ->add('slug', TextType::class, [
            'label' => 'Slug:',
            'required' => true,
            'translation_domain' => false,
        ])
        ->add('thumbnail', TextType::class, [
            'label' => 'Imagen:',
            'required' => false,
            'translation_domain' => false,
        ])
        ->add('thumbnail_alt', TextType::class, [
            'label' => 'Alt:',
            'required' => false,
            'translation_domain' => false,
        ])
        ->add('summary', TextareaType::class, [
            'label' => 'Resumen:',
            'required' => true,
            'translation_domain' => false,
        ])
        ->add('tags', EntityType::class, [
            'label' => 'Tags:',
            'class' => 'AppBundle:Tag',
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => true,
            'translation_domain' => false,
        ])
        ->add('article_extend', ArticleExtendType::class, [
            'label' => 'hy',
        ]);
    }

    public function getName()
    {
        return 'article_form';
    }
}
