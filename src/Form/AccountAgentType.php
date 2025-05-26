<?php


namespace App\Form;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AccountAgentType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => $this->translator->trans('Nom'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Entrer votre nom')
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('champ obligatoire'))
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => $this->translator->trans('Prénom'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Entrer votre prénom')
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('champ obligatoire'))
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => $this->translator->trans('Numero Téléphone'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Numéro Téléphone')
                ],
                'constraints' => [
                    new NotNull([],$this->translator->trans('champ obligatoire'))
                ]
            ])
            ->add('username', TextType::class, [
                'label' => $this->translator->trans('Pseudo'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Entrer votre pseudo'),
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => $this->translator->trans('Le pseudo ne peut pas être vide.'),
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9_-]+$/', 
                        'message' => $this->translator->trans('Le pseudo ne peut contenir que des lettres (sans accent), des chiffres, des underscores (_) et des tirets (-).'),
                    ]),
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('Adresse Mail'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Adresse mail')
                ],
                'required' => false,
                // 'disabled' => true
            ])
            ->add('secteur', SecteurChoiceType::class, [
                'label' => false,
                'mapped' => false,
                'disabled' => true,
                'required' => false,
            ])

            ->add('numero_rue', TextType::class, [
                'label' => $this->translator->trans('Numéro de rue'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Numéro de rue')
                ],
                "required" => false
            ])
            ->add('ville', TextType::class, [
                'label' => $this->translator->trans('Ville'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Ville')
                ],
                "required" => false
            ])
            ->add('pays', ChoiceType::class, [
                'label' => $this->translator->trans('Pays'),
                'placeholder' => $this->translator->trans('Sélectionnez un pays'),
                'choices' => array_flip(Countries::getNames('fr')),
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('codePostal', TextType::class, [
                'label' => $this->translator->trans('Code postal'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Code postal')
                ],
                "required" => false
            ])


            ->add('adresse', TextType::class, [
                'label' => $this->translator->trans('Votre adresse'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Votre adresse')
                ],
                "required" => false
            ])
            ->add('rib', TextType::class, [
                'label' => $this->translator->trans('RIB'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Votre RIB')
                ],
                "required" => false
            ])
        ;
    }
}
