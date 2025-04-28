<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Secteur;
use App\Entity\SearchEntity\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserSearchType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator,
    )
    {
      
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Nom ou prénom')
                ]
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' =>$this->translator->trans('Email') 
                ]
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => $this->translator->trans('Téléphone')
                ]
            ])
            ->add('secteur', EntityType::class, [
                'required' => false,
                'placeholder' => $this->translator->trans('Tous les secteurs'),
                'label' => false,
                'class'=> Secteur::class,
                'choice_label' => 'nom'
            ])
            ->add('dateInscriptionMin', DateType::class, [
                'required' => false,
                'label' => $this->translator->trans('Date d\'inscription à partir de'),
                'widget' => 'single_text',
            ])
            ->add('dateInscriptionMax', DateType::class, [
                'required' => false,
                'label' => $this->translator->trans('Date d\'inscription jusqu\'à'),
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
