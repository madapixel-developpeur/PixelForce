<?php

namespace App\Form;

use App\Entity\CategorieFormation;
use App\Entity\Formation;
use App\Entity\FormationTheme;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FormationThemeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
            ])
            ->add('categorieFormation', EntityType::class, [
                'placeholder' => 'Catégorie',
                'required' => true,
                'label' => false,
                'class' => CategorieFormation::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.statut = 1')
                    ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationTheme::class,
        ]);
    }
}
