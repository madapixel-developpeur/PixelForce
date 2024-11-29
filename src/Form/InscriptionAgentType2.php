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

class InscriptionAgentType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options ["data"];
        $builder
            
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom'
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
            ->add('username', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Identifiant'
                ],
                'constraints' => [
                    new NotNull([],'Champ obligatoire')
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
                    new NotNull([],'Champ obligatoire'),
                ],
                'mapped' => false
            ])            
        ;
        
    }
}
