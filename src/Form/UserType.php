<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'First name',
                'required'   => false,
            ))
            ->add('secondName', TextType::class, array(
                'label' => 'Second name',
                'required'   => false,
            ))
            ->add('email', EmailType::class,array(
                'label' => 'Email *'
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'constraints' => new Length(array('min'=>4)),
                'invalid_message' => 'Passwords do not match.',
                'options' => array('attr' => array('class' => 'simple-input')),
                'first_options'  => array('label' => 'Password *'),
                'second_options' => array('label' => 'Repeat Password *'),
            ))
            ->add('save', SubmitType::class, array(
                'label' => $options['button_label'],
                'attr' => array('class' => 'modern')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'button_label' => 'Submit',
        ]);
    }
}
