<?php

namespace App\Form;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CodePromoFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            "label" => "Titre",
            "required"=>false,
          
        ])
        ->add('code', TextType::class, [
            "label" => "Code",
            "required"=>false,    
        ])
        ->add('minDiscount', IntegerType::class, [
            "label" => "Min promo",
            "required"=>false,    
        ])
        ->add('maxDiscount', IntegerType::class, [
            "label" => "Max promo",
            "required"=>false,    
        ])
        ->add('country', ChoiceType::class, [
            "required"=>false,    
            'choices' => $this->getCountryChoices(),
            'label' => 'Pays',
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    
    private function getCountryChoices(): array
    {
        // dd(array_flip(Countries::getNames('fr')));
        return array_flip(Countries::getNames('fr')); // Get English country names and flip
    }
}
