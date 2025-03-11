<?php


namespace App\Form;


use App\Entity\User;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\FormEvents\SecteurChoiceListListener;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class InscriptionAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options ["data"];
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre nom',
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre prénom',
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])

            ->add('adresse', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre adresse',
                    'step' => 1
                ],
                "required" => true
            ])
            ->add('telephone', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro téléphone',
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postal',
                    'step' => 1
                ],
                "required" => true
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom d\'utilisateur',
                    'step' => 2
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse mail',
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire'),
                ]
            ])

            // ->add('secteur', SecteurChoiceType::class, [
            //     'label' => false,
            //     'mapped' => false,
            // ])

            ->add('password', RepeatedType::class, [
                'label' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe saisi doit être le même.',
                'attr' =>
                    [
                        'step' => 2
                    ],
                'options' => [
                    'attr' =>
                        [
                            'class' => 'password-field',
                            'step' => 2
                        ]
                ],
                'required' => true,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'step' => 2
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Confirmation Mot de passe',
                        'step' => 2
                    ]
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire'),
                ],
                'mapped' => false
            ])
            ->add('numero_rue', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro de rue',
                    'step' => 1
                ],
                "required" => true
            ])
            ->add('ville', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'step' => 1
                ],
                "required" => true
            ])
            ->add('pays', ChoiceType::class, [
                'label' => 'Pays',
                'placeholder' => 'Sélectionnez un pays',
                'choices' => array_flip(Countries::getNames('fr')),
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => "Veuillez choisir un pays"]),
                ],
                'attr' => ['class' => 'form-control', 'step' => 1],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => User::SIGNING_UP_ROLES,
                'expanded' => true,  
                'multiple' => true,  
                'required' => true,  
                'data' => [ User::ROLE_REVENDEUR], 
            ])
            ->addEventSubscriber(new SecteurChoiceListListener())
        ;
        // Ajoutez le champ 'ambassador_username' si la valeur est différente de null
        if ($user->getAmbassadorUsername() !== null) {
            $builder->add('ambassador_username', TextType::class, [
                'label' => "Nom d'utilisateur du parrain",
                'required' => true,
                'disabled' => true
            ]);
        }
    }
}
