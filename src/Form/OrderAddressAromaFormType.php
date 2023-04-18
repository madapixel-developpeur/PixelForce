<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\OrderAddressAroma;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderAddressAromaFormType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class,  [
                "label" => "Nom (*)",
                "required" => true,
                "trim" => true,
            ])
            ->add('firstname', TextType::class,  [
                "label" => "Prénom (*)",
                "required" => true,
                "trim" => true,
            ])
            ->add('phone', TextType::class,  [
                "label" => "Téléphone (*)",
                "required" => true,
                "trim" => true
            ])
            ->add('mail', TextType::class,  [
                "label" => "Adresse e-mail (*)",
                "required" => true,
                "trim" => true
            ])
            ->add('deliveryAddress', TextType::class,  [
                "label" => "Adresse de livraison (*)",
                "required" => true,
                "trim" => true
            ])
            ->add('city', TextType::class,  [
                "label" => "Ville (*)",
                "required" => true,
                "trim" => true
            ])
            ->add('postalCode', TextType::class,  [
                "label" => "Code Postal (*)",
                "required" => true,
                "trim" => true
            ])
            ->add('billingAddress', TextType::class,  [
                "label" => "Adresse de facturation",
                "required" => false,
                "trim" => true
            ])
            ->add('billingPostalCode', TextType::class,  [
                "label" => "Code postal",
                "required" => false,
                "trim" => true
            ])
            ->add('billingCity', TextType::class,  [
                "label" => "Ville",
                "required" => false,
                "trim" => true
            ])  
            ->add('notes', TextareaType::class,  [
                "label" => "Notes",
                "required" => false,
                "attr" =>  ["placeholder" => "Notes à propos de votre commande, ex: des notes spéciales pour la livraison."],
                "trim" => true
            ])  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderAddressAroma::class,
        ]);
    }
}
