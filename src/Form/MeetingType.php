<?php

namespace App\Form;

use App\Entity\Meeting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

class MeetingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Libellé du rendez-vous",
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => "Libellé obligatoire"])
                ]
            ])
            ->add('note', TextareaType::class, [
                'label' => "Note",
                "required" => false,
            ])
            ->add('start', DateTimeType::class, [
                'label' => "Date de début",
                'widget' => 'single_text',
                // 'date_widget' => 'single_text',
                // 'time_widget' => 'single_text',
                'attr' => ['class' => 'datetime-local'],
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => "Date de début obligatoire"])
                ]
            ])
            ->add('end', DateTimeType::class, [
                'label' => "Date de fin",
                'widget' => 'single_text',
                // 'date_widget' => 'single_text',
                // 'time_widget' => 'single_text',
                "required" => false,
                'attr' => ['class' => 'datetime-local'],
                "constraints" => [
                    new NotBlank(["message" => "Date de fin obligatoire"])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meeting::class,
        ]);
    }
}
