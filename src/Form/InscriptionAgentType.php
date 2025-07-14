<?php


namespace App\Form;


use App\Entity\User;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\FormEvents\SecteurChoiceListListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class InscriptionAgentType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator,
        private RequestStack $requestStack)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $locale = $this->requestStack->getCurrentRequest()->getLocale()  ?? 'fr';
        $countryNames = Countries::getNames($locale);


        $rolesWithTranslation = [];
        foreach (User::SIGNING_UP_ROLES as $key => $value) {
            $rolesWithTranslation[$this->translator->trans($key)] = $value;
        }
        $user = $options ["data"];
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' =>  $this->translator->trans('Entrer votre nom'),
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('Champ obligatoire'))
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Entrer votre prénom') ,
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('Champ obligatoire'))
                ]
            ])

            ->add('adresse', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Votre adresse'),
                    'step' => 1
                ],
                "required" => true
            ])
            ->add('telephone', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Numéro téléphone'),
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('Champ obligatoire'))
                ]
            ])
            // ->add('codePostal', TextType::class, [
            //     'label' => false,
            //     'attr' => [
            //         'placeholder' => $this->translator->trans('Code postal'),
            //         'step' => 1
            //     ],
            //     "required" => true
            // ])
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' =>$this->translator->trans('Nom d\'utilisateur') ,
                    'step' => 2
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Champ obligatoire'),
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9_-]+$/', 
                        'message' => $this->translator->trans('Le nom d\'utilisateur ne peut contenir que des lettres (sans accent), des chiffres, des underscores (_) et des tirets (-).'),
                    ]),
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' =>$this->translator->trans('Adresse mail') ,
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('Champ obligatoire')),
                ]
            ])

            // ->add('secteur', SecteurChoiceType::class, [
            //     'label' => false,
            //     'mapped' => false,
            // ])

            ->add('password', RepeatedType::class, [
                'label' => false,
                'type' => PasswordType::class,
                'invalid_message' => $this->translator->trans('Le mot de passe saisi doit être le même.'),
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
                        'placeholder' => $this->translator->trans('Mot de passe'),
                        'step' => 2
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => $this->translator->trans('Confirmation Mot de passe'),
                        'step' => 2
                    ]
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('Champ obligatoire')),
                ],
                'mapped' => false
            ])
            // ->add('numero_rue', TextType::class, [
            //     'label' => false,
            //     'attr' => [
            //         'placeholder' => $this->translator->trans('Numéro de rue'),
            //         'step' => 1
            //     ],
            //     "required" => true
            // ])
            ->add('ville', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Ville'),
                    'step' => 1
                ],
                "required" => true
            ])
            ->add('pays', ChoiceType::class, [
                'label' => $this->translator->trans('Pays'),
                'placeholder' => $this->translator->trans('Sélectionnez un pays'),
                'choices' => array_flip($countryNames),
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => $this->translator->trans("Veuillez choisir un pays")]),
                ],
                'attr' => ['class' => 'form-control', 'step' => 0],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => $rolesWithTranslation,
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
                'label' => $this->translator->trans("Nom d'utilisateur du parrain"),
                'required' => true,
                'disabled' => true
            ]);
        }
    }
}
