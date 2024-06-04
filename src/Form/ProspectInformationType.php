<?php

namespace App\Form;

use App\Entity\Prospect;
use App\Entity\TypeLogement;
use App\Entity\ProspectInformation;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProspectInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $prospect = $builder->getData();
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entrer le prénom du client'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrer le nom du client'
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'placeholder' => 'Entrer l\'adresse mail du client'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Entrer le numéro téléphone du client'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Entrer l\'adresse du client'
                ]
            ])
            ->add('rue', TextType::class, [
                'label' => 'Rue',
                'trim' => true,
                'required' => false
            ])
            ->add('numero', TextType::class, [
                'label' => 'Numéro',
                'trim' => true,
                'required' => false
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'trim' => true,
                'required' => false
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'trim' => true,
                'required' => false
            ])
            ->add('note', CKEditorType::class, [
                'required' => false,
                'label' => 'Note',
                'mapped' => false,
                'data' => $prospect ? $prospect->getNote() : '',
                'config' => [
                    'toolbar' => 'note_contact_toolbar'
                ]
            ])
            ->add('type', ChoiceType::class, [
                "label" => "Type du prospect",
                'choices' => array_flip(Prospect::TYPE_ARRAY_FORM),
                'required' => true,
                'attr' => [
                    'class' => "form-control"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prospect::class,
        ]);
    }
}
