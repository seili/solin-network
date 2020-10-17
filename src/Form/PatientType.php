<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('gender', TextType::class)
            ->add('naissance', BirthdayType::class, [
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]
            ])
            ->add('email', EmailType::class)
            ->add('phone', TelType::class)
            ->add('datedebut', DateTimeType::class, [
                'date_widget' => 'single_text',
            ])
            ->add('datefin', DateTimeType::class, [
                'date_widget' => 'single_text',
            ])
            ->add('background_color', ColorType::class)
            ->add('body', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => 5
                ],
                'label' => 'Body (Optional)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
