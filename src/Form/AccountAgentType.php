<?php


namespace App\Form;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ->add('telephone', TelType::class, [
                'label' => 'Numero Téléphone',
                'attr' => [
                    'placeholder' => 'Numéro Téléphone'
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

            ->add('numero_rue', TextType::class, [
                'label' => 'Numéro de rue',
                'attr' => [
                    'placeholder' => 'Numéro de rue'
                ],
                "required" => false
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                "required" => false
            ])
            ->add('pays', ChoiceType::class, [
                'label' => 'Pays',
                'placeholder' => 'Sélectionnez un pays',
                'choices' => array_flip(Countries::getNames('fr')),
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => 'Code postal'
                ],
                "required" => false
            ])


            ->add('adresse', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => 'Votre adresse'
                ],
                "required" => false
            ])
            ->add('rib', TextType::class, [
                'label' => 'RIB',
                'attr' => [
                    'placeholder' => 'Votre RIB'
                ],
                "required" => false
            ])
        ;
    }
}
