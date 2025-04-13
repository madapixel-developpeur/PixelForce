<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{
    TextType, EmailType, PasswordType, ChoiceType, FileType, RepeatedType
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{
    NotBlank, Length, Email, File, Callback
};

class SignUpLittlePonailsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstnames', TextType::class, [
                'label' => 'Prénom(s)',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner vos prénoms.']),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre nom de famille.']),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur sur Little Ponails",
                'constraints' => [
                    new NotBlank(['message' => "Veuillez renseigner votre nom d'utilisateur."]),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('sponsor', TextType::class, [
                'label' => 'Parrain',
                'required' => false,
                'constraints' => [new Length(['max' => 255])]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre email.']),
                    new Email(['message' => "L'email est invalide"]),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => ['autocomplete' => 'new-password'],
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques.',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner un mot de passe.']),
                    new Length(['min' => 6, 'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.']),
                ],
            ])
            ->add('legal_status', ChoiceType::class, [
                'label' => 'Statut juridique',
                'choices' => [
                    'Revendeur' => 'REVENDEUR',
                    'VDI' => 'VDI',
                ],
                'data' => 'VDI',
                'required' => true,
                'placeholder' => 'Sélectionnez votre statut',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez renseigner votre statut juridique.']),
                ],
            ])
            ->add('supporting_documents', FileType::class, [
                'label' => "Pièce(s) d'identité",
                'mapped' => false,
                'multiple' => true,
                'constraints' => [
                    new NotBlank(['message' => "Veuillez fournir au moins une pièce d'identité."]),
                    // new File([
                    //     'maxSize' => '10M',
                    //     'mimeTypes' => [
                    //         'application/pdf',
                    //         'image/jpeg',
                    //         'image/png',
                    //     ],
                    //     'mimeTypesMessage' => 'Format de fichier invalide.',
                    // ]),
                ]
            ])
            ->add('kbis', FileType::class, [
                'label' => 'KBis',
                'mapped' => false,
                'required' => false,
            ])
            ->add('carte_vitale', FileType::class, [
                'label' => 'Carte Vitale',
                'mapped' => false,
                'required' => false,
            ])
            ->add('siren_vdi', FileType::class, [
                'label' => 'SIREN VDI',
                'mapped' => false,
                'required' => false,
            ])
         
        ;

       /* $builder->addEventListener(\Symfony\Component\Form\FormEvents::POST_SUBMIT, function ($event) {
            $form = $event->getForm();
            $data = $form->getData();

            $status = $data['legal_status'] ?? null;

            if ($status === 'REVENDEUR' && !$form->get('kbis')->getData()) {
                $form->get('kbis')->addError(new \Symfony\Component\Form\FormError('Le KBis est requis pour les revendeurs.'));
            }

            if ($status === 'VDI') {
                if (!$form->get('carte_vitale')->getData()) {
                    $form->get('carte_vitale')->addError(new \Symfony\Component\Form\FormError('La Carte Vitale est requise pour les VDI.'));
                }
                if (!$form->get('siren_vdi')->getData()) {
                    $form->get('siren_vdi')->addError(new \Symfony\Component\Form\FormError('Le SIREN VDI est requis pour les VDI.'));
                }
            }
        });*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
        ]);
    }
}


