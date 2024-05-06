<?php


namespace App\Form;


use App\Form\FormEvents\SecteurChoiceListListener;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class InscriptionAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])

            ->add('adresse', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre adresse'
                ],
                "required" => false
            ])
            ->add('telephone', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro téléphone'
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postal'
                ],
                "required" => false
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom d\'utilisateur'
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse mail'
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
                'options' => [
                    'attr' =>
                        [
                            'class' => 'password-field',
                        ]
                ],
                'required' => true,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Confirmation Mot de passe'
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
                    'placeholder' => 'Numéro de rue'
                ],
                "required" => false
            ])
            ->add('ville', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                "required" => false
            ])
            ->addEventSubscriber(new SecteurChoiceListListener())
        ;
    }
}
