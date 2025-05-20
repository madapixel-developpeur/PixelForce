<?php

namespace App\Form;

use App\Util\LittlePonailsConstant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LpnSupportDocumentFormType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file_support', FileType::class, [
                'label' => $this->translator->trans("Pièce(s) justificatives"),
                'mapped' => false,
                'multiple' => true,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans("Veuillez fournir au moins une pièce justificatives.")]),
                ]
            ])
            ->add('document_type', ChoiceType::class, [
                'label' => $this->translator->trans('Type de document justicative'),
                'choices' => array_flip(LittlePonailsConstant::DOCUMENT_FORM_TYPE),
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => $this->translator->trans("Veuillez choisir un de document justicative")]),
                ],
                'attr' => ['class' => 'form-control'],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
