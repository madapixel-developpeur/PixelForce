<?php

namespace App\Form;

use App\Entity\CatalogueProductSector;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CatalogueProductSectorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Titre obligatoire"])
                ]
            ])
            ->add('shortDescription', TextareaType::class, [
                "label" => "Petite description",
                "required"=>false,
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Petite description obligatoire"])
                ]
            ])
            ->add('redirectionUrl', TextType::class, [
                "label" => "Lien",
                "trim" => true,
                "required" => true,
                'constraints' => [
                    new NotBlank(["message" => "Lien description obligatoire"]),
                    new Url(['message' => 'Veuillez entrer un lien valide.']),
                ],
                'row_attr' => [
                    'type' => 'url', 
                ],
            ])
            ->add('image', FileType::class, [
                "label" => "Image",
                'mapped' => false,
                "required" => false,
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
            'data_class' => CatalogueProductSector::class,
            'isEdit' => false
        ]);
    }
}
