<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CalendlyLinkFilterType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('description', TextType::class, [
            "label" => "Libellé",
            "trim" => true,
            "required" => false
        ])
        ->add('sort', ChoiceType::class, [
            "label" => "Trier par",
            'choices'  => [
                'Identifiant' => "c.id",
                'Nom' => "c.description",
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
