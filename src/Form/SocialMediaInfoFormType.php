<?php

namespace App\Form;

use App\Entity\SocialMediaInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SocialMediaInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Nom obligatoire"])
                ]
            ])
            ->add('link', TextType::class, [
                "label" => "Lien",
                "trim" => true,
                "required" => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un lien.']),
                    new Url(['message' => 'Veuillez entrer un lien valide.']),
                ],
                'row_attr' => [
                    'type' => 'url', // Forces the correct HTML type
                ],
            ])
            ->add('logo', FileType::class, [
                "label" => "Logo",
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
            'data_class' => SocialMediaInfo::class,
            'isEdit' => false
        ]);
    }
}
