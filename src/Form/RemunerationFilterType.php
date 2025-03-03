<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RemunerationFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $types = [
            'Commission achat' => 1,
            'Rémunération équipe' => 2,
            'Bonus palier' => 3,
            'Bonus de lancement' => 4
        ];
        $builder->add('dateMin', DateType::class, [
                'required' => false,
                'label' => 'Date min',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateMax', DateType::class, [
                'required' => false,
                'label' => 'Date max',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'required' => false,
                'label' => 'Type',
                'choices' => $types
            ])
            ->add('label', TextType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('minAmount', IntegerType::class, [
                'required' => false,
                'label' => 'Montant min',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('maxAmount', IntegerType::class, [
                'required' => false,
                'label' => 'Montant max',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return ''; 
    }

}
