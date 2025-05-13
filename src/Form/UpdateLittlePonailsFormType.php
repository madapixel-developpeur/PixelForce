<?php

namespace App\Form;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{
    TextType, EmailType, PasswordType, ChoiceType, FileType, RepeatedType
};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\{
    NotBlank, Length, Email, File, Callback
};

class UpdateLittlePonailsFormType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator,
    )
    {
      
    }

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('identity', FileType::class, [
                'label' => $this->translator->trans("Pièce(s) d'identité"),
                'mapped' => false,
                'multiple' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans("Veuillez fournir au moins une pièce d'identité.")]),
                    // new File([
                    //     'maxSize' => '10M',
                    //     'mimeTypes' => [
                    //         'application/pdf',
                    //         'image/jpeg',
                    //         'image/png',
                    //     ],
                    //     'mimeTypesMessage' => 'Format de fichier invalide.',
                    // ]),
                ]
            ])
            ->add('kbis', FileType::class, [
                'label' => 'KBis',
                'mapped' => false,
                'multiple' => true,
                'required' => true,
            ]);
            

        if($options['need_credentials']){
            $builder->add('password', PasswordType::class, [
                'label' => $this->translator->trans("Mot de passe Little Ponails"),
                'required' => true, 
                ])
            ;
        }

       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'need_credentials' => true
        ]);
    }
}


