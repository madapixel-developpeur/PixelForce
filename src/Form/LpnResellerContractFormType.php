<?php

namespace App\Form;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LpnResellerContractFormType extends AbstractType
{

    public function __construct(
        private TranslatorInterface $translator,
        private RequestStack $requestStack
    ) {
    
    }

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user']; 
        $locale = $this->requestStack->getCurrentRequest()->getLocale()  ?? 'fr';
        $countryNames = Countries::getNames($locale);
        $lpnBoxs = [];
        foreach ($options['lpnBoxs'] as $value) {
            $lpnBoxs[$value['id']] = sprintf("%s (%d€)", $value['name'], $value['price']);
        };
        $builder
            ->add('firstname', TextType::class, [
                'label' => $this->translator->trans('Prénom(s)'),
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('Veuillez renseigner vos prénoms.')]),
                    new Length(['max' => 255]),
                ],
                'data' => $user->getPrenom()
            ])
            ->add('lastname', TextType::class, [
                'label' => $this->translator->trans('Nom de famille'),
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('Veuillez renseigner votre nom de famille.')]),
                    new Length(['max' => 255]),
                ],
                'data' => $user->getNom()
            ])
            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('Adresse email'),
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('Veuillez renseigner votre email.')]),
                    new Email(['message' => $this->translator->trans("L'email est invalide")]),
                    new Length(['max' => 255]),
                ],
                'data' => $user->getEmail()
            ])
            ->add('address', TextType::class, [
                'label' => $this->translator->trans('Votre adresse'),
                'attr' => [
                    'step' => 1
                ],
                "required" => true,
                'constraints' => [
                    new NotNull([], $this->translator->trans('Champ obligatoire'))
                ],
                'data' => $user->getAdresse()
            ])
            ->add('phone_number', TelType::class, [
                'label' => $this->translator->trans('Numéro téléphone'),
                'attr' => [
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([], $this->translator->trans('Champ obligatoire'))
                ],
                'data' => $user->getTelephone()
            ])
            ->add('postal_code', TextType::class, [
                'label' => $this->translator->trans('Code postal'),
                'attr' => [
                    
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([], $this->translator->trans('Champ obligatoire'))
                ],
                "required" => true,
                'data' => $user->getCodePostal()
            ])
            ->add('city', TextType::class, [
                'label' => $this->translator->trans('Ville'),
                'attr' => [
                    'step' => 1
                ],
                "required" => true,
                'constraints' => [
                    new NotNull([], $this->translator->trans('Champ obligatoire'))
                ],
                'data' => $user->getVille()
            ])
            ->add('siren', TextType::class, [
                'label' => $this->translator->trans('N°SIREN'),
                'attr' => [
                    'step' => 1
                ],
                'constraints' => [
                    new NotNull([], $this->translator->trans('Champ obligatoire'))
                ],
                "required" => true
            ])
            ->add('country_code', ChoiceType::class, [
                'label' => $this->translator->trans('Pays'),
                'choices' => array_flip($countryNames),
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => $this->translator->trans("Veuillez choisir un pays")]),
                ],
                'attr' => ['class' => 'form-control', 'step' => 0],
                'data' => empty($user->getPays()) ? '' : $user->getPays()
            ])
            ->add('box', ChoiceType::class, [
                'label' => $this->translator->trans('Box à commander'),
                'choices' => array_flip($lpnBoxs),
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => $this->translator->trans("Veuillez choisir une box")]),
                ],
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);

        $resolver->setRequired('user');
        $resolver->setRequired('lpnBoxs');

        $resolver->setAllowedTypes('user', ['object', UserInterface::class]);
        $resolver->setAllowedTypes('lpnBoxs', 'array');
    }
}
