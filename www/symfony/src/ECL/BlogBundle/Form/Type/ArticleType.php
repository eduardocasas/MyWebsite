<?php
namespace ECL\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use ECL\BlogBundle\Entity\Article;

class ArticleType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'active',
            'checkbox',
            ['label' => 'Activo:', 'required' => false]
        )
        ->add(
            'language',
            'choice', [
                'choices' => [
                     Article::SPANISH_LANGUAGE => 'Español',
                     Article::ENGLISH_LANGUAGE => 'Inglés',
                     Article::BOTH_LANGUAGE    => 'Ambos'
                ],
                'label'    => 'Idioma:',
                'required' => true
            ]
        )
        ->add(
            'title',
            'text', [
                'attr' => ['autofocus' => 'autofocus'],
                'label' => 'Nombre:',
                'required' => true
            ]
        )
        ->add(
            'slug',
            'text',
            ['label' => 'Slug:', 'required' => true]
        )
        ->add(
            'thumbnail',
            'text',
            ['label' => 'Imagen:', 'required' => false]
        )
        ->add(
            'thumbnail_alt',
            'text',
            ['label' => 'Alt:', 'required' => false]
        )
        ->add(
            'summary',
            'textarea',
            ['label' => 'Resumen:', 'required' => true]
        )
        ->add(
            'tags',
            'entity', [
                'label' => 'Tags:', 
                'class' => 'ECLBlogBundle:Tag',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true
            ]
        )
        ->add('article_extend', new ArticleExtendType, ['label' => 'hy']);
    }

    public function getName()
    {
        return 'article_form';
    }

}
