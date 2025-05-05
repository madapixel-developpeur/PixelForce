<?php

namespace App\Form;

use App\Entity\UserInformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserInformationFormType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator,
    )
    {
      
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('portfolioLink', TextType::class, [
                "label" => $this->translator->trans("Portfolio(lien)"),
                "trim" => true,
                "required" => false
            ])
            ->add('portfolioFile', FileType::class, [
                "label" => $this->translator->trans("Portfolio(fichier)"),
                'mapped' => false,
                "required" => false
            ])
            ->add('competence', TextareaType::class, [
                "label" => $this->translator->trans("Compétence"),
                "required"=>false
            ])
            ->add('langues', TextareaType::class, [
                "label" => $this->translator->trans("Langues"),
                "required"=>false
            ])
            ->add('competenceTechnique', TextareaType::class, [
                "label" => $this->translator->trans("Compétence technique"),
                "required"=>false
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserInformation::class,
        ]);
    }
}
