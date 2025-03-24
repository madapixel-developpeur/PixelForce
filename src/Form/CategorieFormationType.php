<?php

namespace App\Form;

use App\Entity\CategorieFormation;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategorieFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description', TextareaType::class, [
                'label' => 'Descritpion',
                'attr' => [
                    'class' => 'tinymce'
                ]
            ])
             ->add('ordreCatFormation', NumberType::class, [
                 'required' => false,
                 'label' => 'Ordre'
             ])
             ->add('isInProgression', CheckboxType::class, [
                'label'    => 'Ajouter à la progression', 
                'required' => false,
                'data'     => true, 
            ])
            ->add('unlockedByDefault', CheckboxType::class, [
                'label'    => "Débloquer les formations par défaut", 
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieFormation::class,
        ]);
    }
}
