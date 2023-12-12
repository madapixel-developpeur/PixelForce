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

class InscriptionAgentOldType extends AbstractType
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
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])

            ->add('adresse', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre adresse'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro téléphone'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code postal'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom d\'utilisateur'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Adresse mail'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire'),
                ]
            ])

            ->add('secteur', SecteurChoiceType::class, [
                'label' => false,
                'mapped' => false,
                'constraints' => [
                    new NotNull([],'champ obligatoire'),
                ]
            ])
            

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
                    new NotNull([],'champ obligatoire'),
                ],
                'mapped' => false
            ])
            ->add('numero_rue', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro de rue'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            
            ->addEventSubscriber(new SecteurChoiceListListener())
        ;
    }
}
