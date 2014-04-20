<?php
namespace ECL\ContactBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'attr' => array(
                    'autofocus'   => 'autofocus',
                    'placeholder' => 'contact.form.name.placeholder',
                    'required'    => true
                )
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'contact.form.email.placeholder',
                    'required'    => true
                )
            ))
            ->add('subject', 'text', array(
                'attr' => array(
                    'placeholder' => 'contact.form.subject.placeholder',
                    'required'    => true
                )
            ))
            ->add('message', 'textarea', array(
                'attr' => array(
                    'placeholder' => 'contact.form.message.placeholder',
                    'required'    => true
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'name' => array(
                new NotBlank(array('message' => 'Name should not be blank.'))
            ),
            'email' => array(
                new NotBlank(array('message' => 'Email should not be blank.'))
            ),
            'subject' => array(
                new NotBlank(array('message' => 'Subject should not be blank.'))
            ),
            'message' => array(
                new NotBlank(array('message' => 'Message should not be blank.'))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'contact';
    }

}
