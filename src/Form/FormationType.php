<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
            ])
            ->add('description_deblocage', TextareaType::class, [
                'required' => true,
            ])
            ->add('contenu', TextareaType::class, [
                'required' => true,
            ])
            ->add('debloqueAgent')
            ->add('brouillon')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}