<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\SearchEntity\OrderSearch;
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

class OrderSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secteur', EntityType::class, [
                'required' => false,
                'placeholder' => 'Tous les secteurs',
                'label' => false,
                'class'=> Secteur::class,
                'choice_label' => 'nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderSearch::class,
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
