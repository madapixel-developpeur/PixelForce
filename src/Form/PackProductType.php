<?php

namespace App\Form;

use App\Entity\PackProduct;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PackProductType extends AbstractType
{
    public function __construct(private ProduitRepository $produitRepository)
    {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $produitList = $this->produitRepository->findAll();
        $builder
            ->add('product', EntityType::class, [
                "label" => "Produit",
                'class'=> Produit::class,
                'choices' => $produitList,
                'choice_label' => function(?Produit $category) {
                    return $category ? strtoupper($category->getNom()) : '';
                },
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Produit obligatoire"])
                ]
            ])
            ->add('qty', IntegerType::class, ['label' => 'Quantité']);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PackProduct::class,
        ]);
    }
}
