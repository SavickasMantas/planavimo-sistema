<?php

namespace App\Form;

use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Schedule title:'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description: '
            ))
            ->add('scheduledEndDate', TextType::class, array(
                'label' => 'Choose your schedules end date: ',
                'attr' => array(
                    'class' => 'form-control datetimepicker-input',
                    'style' => 'margin: 0;',
                    'data-target' => '#datetimepicker1'
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => $options['button_label'],
                'attr' => array('class' => 'modern')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
            'button_label' => 'Create',
        ]);
    }
}
