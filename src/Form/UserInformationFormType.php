<?php

namespace App\Form;

use App\Entity\UserInformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserInformationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('portfolioLink', TextType::class, [
                "label" => "Portfolio(lien)",
                "trim" => true,
                "required" => false
            ])
            ->add('portfolioFile', FileType::class, [
                "label" => "Portfolio(fichier)",
                'mapped' => false,
                "required" => false
            ])
            ->add('competence', TextareaType::class, [
                "label" => "Compétence",
                "required"=>false
            ])
            ->add('langues', TextareaType::class, [
                "label" => "Langues",
                "required"=>false
            ])
            ->add('competenceTechnique', TextareaType::class, [
                "label" => "Compétence technique",
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
