<?php

namespace AppBundle\Form\Type\Contact;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'contact.form.name.label',
                'attr' => [
                    'autofocus' => 'autofocus',
                    'placeholder' => 'contact.form.name.placeholder',
                    'required' => true,
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'contact.form.email.label',
                'attr' => [
                    'placeholder' => 'contact.form.email.placeholder',
                    'required' => true,
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'contact.form.subject.label',
                'attr' => [
                    'placeholder' => 'contact.form.subject.placeholder',
                    'required' => true,
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'contact.form.message.label',
                'attr' => [
                    'placeholder' => 'contact.form.message.placeholder',
                    'required' => true,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $collectionConstraint = new Collection([
            'name' => [new NotBlank(['message' => 'Name should not be blank.'])],
            'email' => [new NotBlank(['message' => 'Email should not be blank.'])],
            'subject' => [new NotBlank(['message' => 'Subject should not be blank.'])],
            'message' => [new NotBlank(['message' => 'Message should not be blank.'])],
        ]);

        $resolver->setDefaults(['constraints' => $collectionConstraint]);
    }

    public function getName()
    {
        return 'contact';
    }
}
