<?php

namespace App\Form;

use App\Entity\CategorieFormation;
use App\Entity\SearchEntity\CategorieFormationSearch;
use App\Entity\SearchEntity\UserSearch;
use App\Entity\Secteur;
use App\Repository\CategorieFormationRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieFormationSearchType extends AbstractType
{
    protected $repoCatFormation;

    public function __construct( CategorieFormationRepository $repoCatFormation)
    {
        $this->repoCatFormation = $repoCatFormation;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description'
                ]
            ])
            ->add('statut', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'STATUT',
                'choices' => [
                    'Activé' => 1,
                    'Supprimé' => -1
                ],
                'data' => 1
            ])
            ->add('isInProgression', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'placeholder' => 'STATUT PROGRESSION',
                'choices' => [
                    'Tout' => null,
                    "Prise en compte" => true,
                    "Non prise en compte" => false
                ],
            ])
            
            ->add('ordre', EntityType::class, [
                'placeholder' => 'ORDRE',
                'required' => false,
                'label' => false,
                'class' => CategorieFormation::class,
                'choice_label' => 'ordreCatFormation',
            ])
        ;
    }

    public function getAllCategories()
    {
        return $categories = $this->repoCatFormation->findAll();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategorieFormationSearch::class,
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
