<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'label' =>'Titre de la réponse',
                'constraints' =>[
                    new NotBlank([
                        'message' => 'Le titre de problème  est obligatoire',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Titre de la réponse',
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
            'data_class' => Reponse::class
        ]);
    }

    // on modifie les paramettre (pour les rendre lisibles) dans l'url lors d'une recheche
    public function getBlockPrefix()
    {
        return '';
    }

    
}
