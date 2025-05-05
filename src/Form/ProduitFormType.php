<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\Validator\Constraints\Regex;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitFormType extends AbstractType
{
    private $categorieRepository;
    public function __construct(CategorieRepository $categorieRepository,
        private TranslatorInterface $translator,
    ){
        $this->categorieRepository = $categorieRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categoryList = $this->categorieRepository->findAll();
        $builder
            ->add('nom', TextType::class, [
                "label" => $this->translator->trans("Nom"),
                "trim" => true,
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => $this->translator->trans("Nom obligatoire")])
                ]
            ])
            ->add('description', CKEditorType::class,  array(
                'config' => array(
                    'uiColor' => '#ffffff',
                    //'uiColor' => '#7367f0',


                )))
            ->add('prix', TextType::class, [
                "label" => "Prix",
                "trim" => true,
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => $this->translator->trans("Prix obligatoire")]),
                    new Regex(["pattern"=>'/^[0-9]*([\.])?[0-9]*$/',"match"=>true,"message" => $this->translator->trans("Le prix n'est pas valide")])
                ]
            ])
            ->add('categorie', EntityType::class, [
                "label" => "Catégorie",
                'class'=> Categorie::class,
                'choices' => $categoryList,
                'choice_label' => function(?Categorie $category) {
                    return $category ? strtoupper($category->getNom()) : '';
                },
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => $this->translator->trans("Catégorie obligatoire")])
                ]
            ])
            ->add('imageFile', FileType::class, [
                "label" => "Image",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => $this->translator->trans('Image invalide. Le format doit être: .jpeg ou .png'),
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
