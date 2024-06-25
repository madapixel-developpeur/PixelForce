<?php

namespace App\Form;

use App\Entity\SearchEntity\UserSearch;
use App\Entity\Secteur;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuditSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProjet', TextType::class, [
                'required' => false,
                'label' =>'Nom du projet',
                'attr' => [
                    'placeholder' => 'Nom ou prénom'
                ]
            ])
            ->add('urlSite', TextType::class, [
                'required' => false,
                'label' =>"Url du site",
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            ->add('description', EntityType::class, [
                'required' => false,
                'placeholder' => 'Tous les secteurs',
                'label' => false,
                'class'=> Secteur::class,
                'choice_label' => 'nom'
            ])
            ->add('dateAjoutMin', DateType::class, [
                'required' => false,
                'label' => 'Date d\'ajout à partir de',
                'widget' => 'single_text',
            ])
            ->add('dateAjoutMax', DateType::class, [
                'required' => false,
                'label' => 'Date d\'ajout jusqu\'à',
                'widget' => 'single_text',
            ])
            // ->add('order', DateType::class, [
            //     'required' => false,
            //     'label' => false,
            //     'widget' => 'single_text',
            // ])
            ->add('active', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => [
                    'Tous' => null,
                    'Activé' => 1,
                    'Banni' => -1
                ]
            ])

            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'required' => false,
                'label' => false,
                'choice_label' => 'libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    // on modifie les paramettre (pour les rendre lisibles) dans l'url lors d'une recheche
    public function getBlockPrefix()
    {
        return '';
    }

    
}
