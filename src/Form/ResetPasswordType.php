<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Validator\PasswordConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Le mot de passe saisi doit être le même.',
                    'options' => [
                        'attr' =>
                            [
                                'class' => 'password-field',
                                'placeholder' => 'xxxxxxxxxx'
                            ]
                    ],
                    'required' => true,
                    'first_options'  => [
                        'label' => 'Nouveau mot de passe',

                    ],
                    'second_options' => ['label' => 'Confirmation du mot de passe'],
                    'mapped' => false,
                    'constraints' => [
                        new Length([
                            'min' => 8,
                            'minMessage' => 'Minimum 8 caractères - plus il y en a, mieux c\'est',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new NotBlank([
                            'message' => 'Le mot de passe ne doit pas être vide',
                            'groups' => 'password_update'
                        ]),
                        new PasswordConstraint()
                    ]
                ]
            )
        ;
    }
}
