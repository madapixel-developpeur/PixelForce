<?php

namespace App\Form;

use App\Entity\CalendlyLink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\File;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints\NotNull;

class CalendlyLinkFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link', TextType::class, [
                "label" => "Lien",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Lien obligatoire"])
                ]
            ])
            ->add('description', TextType::class, [
                "label" => "Libellé",
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Libellé obligatoire"])
                ]
            ])
            ->add('image', HiddenType::class, [
                "label" => false,
                "trim" => true,
                "required" => false,
            ])
            // ->add('imageFile', FileType::class, [
            //     "label" => "Image",
            //     'mapped' => false,
            //     "required" => false,
            //     'constraints' => [
            //         new File([
            //             // 'maxSize' => '1024k',
            //             'mimeTypes' => [
            //                 'image/jpeg',
            //                 'image/png',
            //                 'image/gif',
            //                 'image/bmp',
            //                 'image/webp',
            //                 'image/x-icon',
            //                 'image/tiff',
            //                 'image/svg+xml'
            //             ],
            //             'mimeTypesMessage' => 'Image invalide.',
            //         ])
            //     ]
            // ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CalendlyLink::class,
        ]);
    }
}
