<?php

namespace App\Form;

use DateTime;
use Mpdf\Tag\TextArea;
use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

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
        ->add('startDate', DateTimeType::class, [
            'label' => 'Début',
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control',
                'id' => 'default-date',
            ],
            'constraints' => [
                new GreaterThanOrEqual([
                    'value' =>new DateTime(),
                    'message' => "Date déjà passée"
                ])
            ],
        ])
        ->add('endDate', DateTimeType::class,[
            "label" => "Fin",
            'widget' => 'single_text',
            'required' =>false,
            'attr' => [
                // 'class' => 'datepicker',
                'id' => 'default-date',
            ],
            'constraints' => [
                new GreaterThanOrEqual([
                    'value' =>new DateTime(),
                    'message' => "Date déjà passée"
                ])
            ],
        ])
        ->add('ville', TextType::class, [
            'label' => 'Ville',
            'required' =>false,
            'attr' => [
                'placeholder' => ''
            ]
        ])
        ->add('filePath', FileType::class, [
            "label" => "Image pour bannière",
            'mapped' => false,
            "required" => $options['isCreation'],
            'constraints' => [
                new File([
                    // 'maxSize' => '1024k',
                    'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                    'mimeTypesMessage' => 'Image invalide. Le format doit être: .jpeg ou .png',
                ])
            ]
        ])
        ->add('couvertureFilePath', FileType::class, [
            "label" => "Image pour couverture ",
            'mapped' => false,
            "required" => $options['isCreation'],
            'constraints' => [
                new File([
                    // 'maxSize' => '1024k',
                    'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
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
            'isCreation' => false,
        ]);
    }
}
