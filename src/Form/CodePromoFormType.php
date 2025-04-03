<?php

namespace App\Form;

use App\Entity\CodePromo;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CodePromoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Titre est obligatoire.']),
                ],
            ])
            ->add('code', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Code obligatoire.']),
                ],
            ])
            ->add('discount', IntegerType::class, [
                'label' => "Promo (0% - 100%)",
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Pourcentage obligatoire.']),
                    new Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Le pourcentage doit être compris entre 0 et 100.',
                    ]),
                ],
            ])
            ->add('startDate',DateTimeType::class, [
                'label' => "Date de début",
                'widget' => 'single_text',
                'attr' => ['class' => 'datetime-local'],
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Date de début obligatoire"])
                ]
            ])
            ->add('endDate',DateTimeType::class, [
                'label' => "Date de fin",
                'widget' => 'single_text',
                'attr' => ['class' => 'datetime-local'],
                "required" => false
            ])
            ->add('countries', ChoiceType::class, [
                'choices' => $this->getCountryChoices(),
                'multiple' => true,
                'mapped' => false,
                'label' => 'Pays',
                'data' => $options['selected_countries'], 
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CodePromo::class,
            'selected_countries' => [],
        ]);
        $resolver->setAllowedTypes('selected_countries', 'array');
    }

    private function getCountryChoices(): array
    {
        // dd(array_flip(Countries::getNames('fr')));
        return array_flip(Countries::getNames('fr')); // Get English country names and flip
    }
}
