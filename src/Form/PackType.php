<?php

namespace App\Form;

use App\Entity\Pack;
use App\Entity\PackCategory;
use App\Entity\PackProduct;
use App\Entity\Produit;
use App\Repository\PackCategoryRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class PackType extends AbstractType
{
    public function __construct(private PackCategoryRepository $packCategoryRepository)
    {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // https://symfony.com/doc/current/form/form_collections.html
        $categoryList = $this->packCategoryRepository->findAllActivePackCategory();
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Nom du pack obligatoire"])
                ]
            ])
            ->add('description', TextareaType::class,  [
                "label" => "Description",
                "trim" => true,
                "required" => false
            ])
            ->add('cost', NumberType::class,  [
                "label" => "Montant du pack",
                "trim" => true,
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => "Montant du pack obligatoire"])
                ]
            ])
            ->add('packCategory', EntityType::class, [
                "label" => "Catégorie du pack",
                'class'=> PackCategory::class,
                'choices' => $categoryList,
                'choice_label' => function(?PackCategory $category) {
                    return $category ? strtoupper($category->getName()) : '';
                },
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Catégorie obligatoire"])
                ]
            ])
            // ->add('products', CollectionType::class, [
            //     // 'entry_type' => PackProductType::class,
            //     // 'entry_options' => [
            //     //     'label' => false,
            //     // ],
            //     // 'allow_add' => true,
            //     // 'by_reference' => false,
            //     'entry_type' => TextType::class,
            //     'label' => 'Produits',
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'prototype' => true,
            //     'prototype_data' => "URL d'une video youtube",
            //     'entry_options' => [
            //         'help' => 'You can edit this name here.',
            //     ],
            // ])
            ->add('products', CollectionType::class, [
                "label" => "Liste des items",
                'entry_type' => PackProductType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ])
            // ->add('imageFile', FileType::class, [
            //     "label" => "Image d'illustration",
            //     'mapped' => false,
            //     "required" => false,
            //     'constraints' => [
            //         new File([
            //             // 'maxSize' => '1024k',
            //             'mimeTypes' => [
            //                 'image/jpeg',
            //                 'image/png',
            //             ],
            //             'mimeTypesMessage' => 'Image invalide. Le format doit être: .jpeg ou .png',
            //         ])
            //     ]
            // ])
            ->add('documentFile', FileType::class, [
                "label" => "Document (.pdf)",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf'
                        ],
                        'mimeTypesMessage' => 'Document invalide. Le format doit être: .pdf',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pack::class,
        ]);
    }
}
