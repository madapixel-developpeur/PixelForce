<?php

namespace App\Form;
use App\Entity\Solution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SolutionType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Solution::class
        ]);
    }

    // on modifie les paramettre (pour les rendre lisibles) dans l'url lors d'une recheche
    public function getBlockPrefix()
    {
        return '';
    }

    
}
