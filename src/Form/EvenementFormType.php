<?php

namespace App\Form;

use DateTime;
use Mpdf\Tag\TextArea;
use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

class EvenementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'attr' => [
                'placeholder' => ''
            ]
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'attr' => [
                'placeholder' => ''
            ]
        ])
        ->add('startDate', DateType::class, [
            'label' => 'Début',
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control',
                'id' => 'default-date',
            ],
        ])
        ->add('endDate', DateType::class, [
            "label" => "Fin",
            'widget' => 'single_text',
            'attr' => [
                // 'class' => 'datepicker',
                'id' => 'default-date',
            ]
        ])
        ->add('filePath', FileType::class, [
            "label" => "Fichier ",
            'mapped' => false,
            "required" => false,
            'constraints' => [
                new File([
                    // 'maxSize' => '1024k',
                    'mimeTypesMessage' => 'Image invalide. Le format doit être: .jpeg ou .png',
                ])
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
