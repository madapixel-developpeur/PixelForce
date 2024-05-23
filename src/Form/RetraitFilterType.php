<?php

namespace App\Form;

use App\Entity\UserTransaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RetraitFilterType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('userName', TextType::class, [
            "label" => "Nom et prénoms",
            "required" => false
        ])
        ->add('dateMin', DateTimeType::class, [
            "label" => "Date min",
            "required" => false,
            "input_format" => "d/m/Y H:i",
            "widget" => "single_text"
        ])
        ->add('dateMax', DateTimeType::class, [
            "label" => "Date max",
            "required" => false,
            "input_format" => "d/m/Y H:i",
            "widget" => "single_text"
        ])
        ->add('status', ChoiceType::class, [
            "label" => "Statut",
            'choices'  => [
                "En attente" => UserTransaction::STATUS_CREATED,
                "Validé" => UserTransaction::STATUS_VALID,
                "Refusé" => UserTransaction::STATUS_CANCELLED,
            ],
            "required" => false
        ]) 
        ->add('sort', ChoiceType::class, [
            "label" => "Trier par",
            'choices'  => [
                'Date' => "ut.createdAt",
                'Montant' => "ut.amount",
            ],
            "required" => false
        ])
        ->add('direction', ChoiceType::class, [
            "label" => "Ordre",
            'choices'  => [
                'Croissant' => "asc",
                'Décroissant' => "desc"
            ],
            "required" => false
        ])
        ->add('rib', TextType::class, [
            "label" => "RIB",
            "required" => false
        ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
