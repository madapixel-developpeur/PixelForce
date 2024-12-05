<?php


namespace App\Form;

use App\Services\CountryService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AccountAgentType extends AbstractType
{
    public function __construct(private CountryService $countryService)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ],
                'required' => false,
                'trim' => true,
                // 'constraints' => [
                //     new NotNull([],'champ obligatoire')
                // ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ],
                'required' => true,
                'trim' => true,
                'constraints' => [
                    new NotBlank([], 'Prénom obligatoire')
                ]
            ])

            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Votre Adresse'
                ],
                'required' => false,
                'trim' => true,
                // 'constraints' => [
                //     new NotNull([], 'champ obligatoire')
                // ]
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numero Téléphone',
                'attr' => [
                    'placeholder' => 'Numéro Téléphone'
                ],
                'required' => false,
                'trim' => true,
                // 'constraints' => [
                //     new NotNull([], 'champ obligatoire')
                // ]
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'placeholder' => 'Code postal'
                ],
                'required' => false,
                'trim' => true,
                // 'constraints' => [
                //     new NotNull([], 'champ obligatoire')
                // ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Identifiant',
                'attr' => [
                    'placeholder' => 'Entrer votre identifiant',
                    'disabled' => true
                ],
                // 'required' => true,
                // 'constraints' => [
                //     new NotBlank([], 'Identifiant obligatoire')
                // ]
            ])

            // ->add('email', EmailType::class, [
            //     'label' => 'Adresse Mail',
            //     'attr' => [
            //         'placeholder' => 'Adresse mail',
            //         // 'disabled' => true
            //     ],
            // 'required' => true,
            // 'constraints' => [
            //     new NotBlank([], 'Adresse email obligatoire')
            // ]
            // 'disabled' => true
            // ])
            ->add('countryCode', ChoiceType::class, [
                'choices' => $this->getCountryChoices(), // Custom method to define choices
                'label' => 'Pays',
                // 'placeholder' => 'Choose a country', // Optional: adds a default placeholder
                'required' => true,                 // Optional: make the field required
                'attr' => [
                    'placeholder' => 'Pays'
                ],
            ])
            // ->add('secteur', SecteurChoiceType::class, [
            //     'label' => false,
            //     'mapped' => false,
            //     'disabled' => true,
            //     'required' => false,
            // ])
            // ->add('rib', TextType::class, [
            //     'label' => 'RIB',
            //     'attr' => [
            //         'placeholder' => 'Votre RIB'
            //     ],
            //     'constraints' => [
            //         new NotNull([],'champ obligatoire')
            //     ]
            // ])
        ;
    }

    private function getCountryChoices(): array
    {
        $data = $this->countryService->readJson();
        $transformed = [];
        foreach ($data as $code => $name) {
            $transformed[$name] = $code;
        }
        return $transformed;
    }
}
