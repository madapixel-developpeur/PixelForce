<?php

namespace App\Form;

use App\Entity\NewsLetters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NewsLettersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'required' =>false,
                'attr' => [
                    'placeholder' => ''
                ]
            ])
            ->add('objet', TextType::class, [
                'label' => 'Objet',
                'required' =>false,
                'attr' => [
                    'placeholder' => ''
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => [
                    'placeholder' => ''
                ]
            ])
        ;

        $builder->setAttributes([
            'enctype' => 'multipart/form-data',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsLetters::class,
        ]);
    }
}
