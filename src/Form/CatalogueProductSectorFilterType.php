<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CatalogueProductSectorFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                "trim" => true,
                "required" => false
            ])
            ->add('shortDescription', TextType::class, [
                "label" => "Petite description",
                "required"=>false,
                "trim" => true,
            ])
            ->add('redirectionUrl', TextType::class, [
                "label" => "Lien",
                "trim" => true,
                "required" => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
