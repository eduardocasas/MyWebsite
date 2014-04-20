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
            array('label' => 'Activo:', 'required' => false)
        )
        ->add(
            'language',
            'choice',
            array(
                 'choices' => array(
                     Article::SPANISH_LANGUAGE => 'Español',
                     Article::ENGLISH_LANGUAGE => 'Inglés',
                     Article::BOTH_LANGUAGE    => 'Ambos'
                ),
                'label'    => 'Idioma:',
                'required' => true
            )
        )
        ->add(
            'title',
            'text',
            array(
                'attr' => array('autofocus' => 'autofocus'),
                'label' => 'Nombre:',
                'required' => true
            )
        )
        ->add(
            'slug',
            'text',
            array('label' => 'Slug:', 'required' => true)
        )
        ->add(
            'thumbnail',
            'text',
            array('label' => 'Imagen:', 'required' => false)
        )
        ->add(
            'thumbnail_alt',
            'text',
            array('label' => 'Alt:', 'required' => false)
        )
        ->add(
            'summary',
            'textarea',
            array('label' => 'Resumen:', 'required' => true)
        )
        ->add(
            'tags',
            'entity',
            array(
                'label'    => 'Tags:', 
                'class'    => 'ECLBlogBundle:Tag',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true
            )
        )
        ->add(
            'article_extend',
            new ArticleExtendType(),
            array('label' => 'hy')
        );
    }

    public function getName()
    {
        return 'article_form';
    }

}
