<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\FormationTheme;
use App\Entity\CategorieFormation;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Le titre est obligatoire.']),
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'La description est obligatoire.']),
                ],
            ])
            // ->add('description_deblocage', TextareaType::class, [
            //     'required' => false,
            //     'label' => 'Description déblocage'
            // ])
            ->add('contenu', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
                'required' => false,
            ])
            // ->add('debloqueAgent', null, [
            //     'label' => 'Disponible pour tous les agents'
            // ])
            ->add('brouillon')
            ->add('categorieFormation', EntityType::class, [
                'placeholder' => 'CATEGORIE',
                'label' => false,
                'class' => CategorieFormation::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.statut = 1')
                    ;
                },
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Champ obligatoire.']),
                ],
            ])
            ->add('theme', EntityType::class, [
                'label' => 'Thème',
                'class' => FormationTheme::class,
                'choice_label' => 'titre',
                // 'query_builder' => function (EntityRepository $er) {
                //     return $er->createQueryBuilder('ft')
                //         ->where('ft.statut = 1')
                //     ;
                // },
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
