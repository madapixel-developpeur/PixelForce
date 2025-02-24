<?php

namespace App\Form;

use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnouncementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "label" => "Titre",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Nom obligatoire"])
                ]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "required"=>false,
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Description obligatoire"])
                ]
            ])
            ->add('startDate',DateTimeType::class, [
                'label' => "Date de début",
                'widget' => 'single_text',
                'attr' => ['class' => 'datetime-local'],
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => "Date de début obligatoire"])
                ]
            ])
            ->add('endDate',DateTimeType::class, [
                'label' => "Date de fin",
                'widget' => 'single_text',
                'attr' => ['class' => 'datetime-local'],
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => "Date de fin obligatoire"])
                ]
            ])
            ->add('filepath', FileType::class, [
                "label" => "Bannière",
                'mapped' => false,
                "required" => !$options['isEdit'],
                'constraints' => array_merge(
                    [new File([
                        'mimeTypes' => [
                            "image/jpeg",
                            "image/png",
                            "image/gif",
                            "image/webp"
                        ],
                        'mimeTypesMessage' => 'Sélectionnez une image valide (JPEG, PNG, GIF, WebP)',
                    ])],
                    !$options['isEdit'] ? [new NotNull(["message" => "Une image est obligatoire"])] : []
                )
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
            'isEdit' => false
        ]);
    }
}
