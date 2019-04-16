<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Task title:'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description: '
            ))
            ->add('detail', TextareaType::class, array(
                'label' => 'Detail: '
            ))
            ->add('taskEndDate', TextType::class, array(
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
            'data_class' => Task::class,
            'button_label' => 'Create',
        ]);
    }
}
