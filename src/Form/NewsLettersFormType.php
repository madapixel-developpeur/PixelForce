<?php

namespace App\Form;

use App\Entity\NewsLetters;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
                'required' =>true,
                'attr' => [
                    'placeholder' => ''
                ]
            ])
            ->add('objet', TextType::class, [
                'label' => 'Objet',
                'required' =>true,
                'attr' => [
                    'placeholder' => ''
                ]
            ])
            ->add('content',  CKEditorType::class, [
                'label' => 'Contenu',
                'config' => [
                    'toolbar' => 'custom_config',
                ],
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',
                    'rows'  => 9
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
