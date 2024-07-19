<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\FormationPageConfiguration;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormationPageConfigurationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('introductionVideo', TextType::class, [
                'label' => "Lien de la video d'introduction",
                'required' => true,
            ])
            ->add('introductionPhoto', FileType::class, [
                "label" => "Image",
                'mapped' => false,
                "required" => $options['isCreation'],
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image invalide. Le format doit être: .jpeg ou .png',
                    ])
                ]
            ])
            ->add('heureFormation', TextType::class, [
                "label" => "Durée de la formation(ex: 99min,1h20min,..)",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Durée de la formation obligatoire"])
                ]
            ])
            ->add('description', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#cccccc',
                ],
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationPageConfiguration::class,
            'isCreation' => false,
        ]);
    }
}
