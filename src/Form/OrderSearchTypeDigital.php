<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Package;
use App\Entity\SearchEntity\OrderSearch;
use App\Repository\PackageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderSearchTypeDigital extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // dd($this->getPackageWithService(), $this->repoPackage->findAll());


        $builder
            ->add('clientName', TextType::class, [
                'required' => false,
                'label' => 'Client',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
         
            ->add('dateMin', DateType::class, [
                'required' => false,
                'label' => 'Date min',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateMax', DateType::class, [
                'required' => false,
                'label' => 'Date max',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
          
            ->add('status', ChoiceType::class, [
                'required' => false,
                'label' => 'Statut',
                'choices' => [
                    'Tous' => null,
                    'Créé' => 0,
                    'Payé' => 1,
                ]
            ])
            ->add('referenceVente', TextType::class, [
                'required' => false,
                'label' => 'Référence',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
      
        $resolver->setDefaults([
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
