<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Secteur;
use App\Entity\Probleme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProblemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'label' =>'Titre du problème',
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Le titre de problème  est obligatoire',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Titre du problème',
                ]
            ])
            
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => "Description",
                'constraints' =>[
                    new NotBlank([
                        'message' => 'La description  est obligatoire',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Description',
                ]
            ])   
            ->add('noteRisque', IntegerType::class, [
                'required' => false,
                'label' =>"Note du risque",
                'attr' => [
                    'placeholder' => 'Note du risque',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le note du risque est obligatoire',
                    ]),
                    new Range([
                        'min' => 0,
                        'max' => 10,
                        'notInRangeMessage' => 'La valeur doit être comprise entre {{ min }} et {{ max }}.',
                    ]),
                ],
            ])  
            ->add('fichier', FileType::class, [
                "label" => "Fichier ",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Image invalide. Le format doit être: .jpeg ou .png',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Probleme::class
        ]);
    }

    // on modifie les paramettre (pour les rendre lisibles) dans l'url lors d'une recheche
    public function getBlockPrefix()
    {
        return '';
    }

    
}
