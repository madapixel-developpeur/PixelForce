<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;

class AccountAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])

            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Votre Adresse'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numero Téléphone',
                'attr' => [
                    'placeholder' => 'Numéro Téléphone'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => 'Code postal'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'attr' => [
                    'placeholder' => 'Entrer votre pseudo',
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Adresse Mail',
                'attr' => [
                    'placeholder' => 'Adresse mail'
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
            ->add('rib', TextType::class, [
                'label' => 'RIB',
                'attr' => [
                    'placeholder' => 'Votre RIB'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
        ;
    }
}
