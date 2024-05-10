<?php

namespace App\Form;

use App\Entity\Secteur;
use App\Entity\TypeSecteur;
use App\Repository\TypeSecteurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class SecteurType extends AbstractType
{
    private $typeSecteurRepository;
    public function __construct(TypeSecteurRepository $typeSecteurRepository){
        $this->typeSecteurRepository = $typeSecteurRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $types = $this->typeSecteurRepository->findAll();
        $builder
            ->add('nom', null, ['attr' => ['placeholder' => 'Nom du secteur']])
            ->add('title', null, 
                [
                    'attr' => ['placeholder' => 'Titre du secteur'],
                    'label' => "Titre",
                ]
            )
            ->add('description', null, ['attr' => ['placeholder' => 'Description du secteur']])
            ->add('longDescription', CKEditorType::class, [
                'required' => false,
                'label' => "Longue description",
                'config' => [
                    'toolbar' => 'note_contact_toolbar'
                ]
            ])
            ->add('liens', null, 
                [
                    'attr' => ['placeholder' => 'liens vers la page du secteur'],
                ]
            )
            ->add('type', EntityType::class, [
                "label" => "Type",
                'class'=> TypeSecteur::class,
                'choices' => $types,
                'choice_label' => function(?TypeSecteur $type) {
                    return $type ? strtoupper($type->getNom()) : '';
                },
                "required" => true,
                "constraints" => [
                    new NotNull(["message" => "Type obligatoire"])
                ]
            ])
            ->add('couverture', FileType::class, [
                "label" => "Couverture",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image invalide. Le format doit être: .jpeg ou .png',
                    ])
                ]
            ])
            ->add('affiche', FileType::class, [
                "label" => "Affiche",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Image invalide. Le format doit être: .jpeg ou .png',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Secteur::class,
        ]);
    }
}
