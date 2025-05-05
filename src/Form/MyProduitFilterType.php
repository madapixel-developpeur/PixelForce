<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;


use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


    class MyProduitFilterType extends AbstractType
{
    private $categorieRepository;
    public function __construct(CategorieRepository $categorieRepository,
        private TranslatorInterface $translator,
    ){
        $this->categorieRepository = $categorieRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $categoryList = $this->categorieRepository->getValidCategories();
        $builder
        ->add('nom', TextType::class, [
            "label" => false,
            "trim" => true,
            "required" => false,
            "attr" => [
                "placeholder" => $this->translator->trans("Nom")
            ]
        ])
        ->add('description', TextType::class, [
            "label" => false,
            "trim" => true,
            "required" => false,
            "attr" => [
                "placeholder" => $this->translator->trans("Description")
            ]
        ])
        ->add('categorie', EntityType::class, [
            "label" => false,
            'class'=> Categorie::class,
            'choices' => $categoryList,
            'choice_label' => function(?Categorie $category) {
                return $category ? strtoupper($category->getNom()) : '';
            },
            "required" => false,
            "placeholder" => $this->translator->trans("Catégorie")
        ])
        ->add('prixMin', TextType::class, [
            "label" => false,
            "trim" => true,
            "required" => false,
            "attr" => [
                "placeholder" => $this->translator->trans("Prix mininum")
            ]
        ])
        ->add('prixMax', TextType::class, [
            "label" => false,
            "trim" => true,
            "required" => false,
            "attr" => [
                "placeholder" => $this->translator->trans("Prix maximum")
            ]
        ])
        ->add('sort', ChoiceType::class, [
            "label" => false,
            'choices'  => [
                'Identifiant' => "p.id",
                'Nom' => "p.nom",
                'Prix' => "p.prix"
            ],
            "required" => false,
            "placeholder" => $this->translator->trans("Trier par")
        ])
        ->add('direction', ChoiceType::class, [
            "label" => false,
            'choices'  => [
                'Croissant' => "asc",
                'Décroissant' => "desc"
            ],
            "required" => false,
            "placeholder" => $this->translator->trans("Ordre")
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
