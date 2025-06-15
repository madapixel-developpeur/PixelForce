<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PaymentInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('RIB', TextType::class, [
                "label" => "RIB",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Champ obligatoire"])
                ]
            ])
            ->add('checkRecipient', TextType::class, [
                "label" => "Info déstinataire",
                "trim" => true,
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => "Champ obligatoire"])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
