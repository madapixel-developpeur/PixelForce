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
            
            ->add('supporting_documents', FileType::class, [
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
            ])
        ;

        // $builder->addEventListener(\Symfony\Component\Form\FormEvents::POST_SUBMIT, function ($event) {
        //     $form = $event->getForm();
        //     $data = $form->getData();

        //     $status = $data['legal_status'] ?? null;

        //     if ($status === 'REVENDEUR' && !$form->get('kbis')->getData()) {
        //         $form->get('kbis')->addError(new \Symfony\Component\Form\FormError($this->translator->trans('Le KBis est requis pour les revendeurs.')));
        //     }

        //     if ($status === 'VDI') {
        //         if (!$form->get('carte_vitale')->getData()) {
        //             $form->get('carte_vitale')->addError(new \Symfony\Component\Form\FormError($this->translator->trans('La Carte Vitale est requise pour les VDI.')));
        //         }
        //         if (!$form->get('siren_vdi')->getData()) {
        //             $form->get('siren_vdi')->addError(new \Symfony\Component\Form\FormError($this->translator->trans('Le SIREN VDI est requis pour les VDI.')));
        //         }
        //     }
        // });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
        ]);
    }
}


