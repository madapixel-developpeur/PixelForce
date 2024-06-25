<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Audit;
use App\Entity\Secteur;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AuditType extends AbstractType
{
    private $entityManager;
    private $secteurRepository;

    public function __construct(EntityManagerInterface $entityManager,SecteurRepository $secteurRepository)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder
            ->add('nomProjet', TextType::class, [
                'required' => true,
                'label' =>'Nom du projet',
                'attr' => [
                    'placeholder' => 'Nom du projet',
                ],
                "constraints" => [
                    new NotBlank(["message" => "Le nom du projet est obligatoire"])
                ]
            ])
            ->add('urlSite', TextType::class, [
                'required' => false,
                'label' =>"Url du site",
                'attr' => [
                    'placeholder' => 'Url du site',
                ],
                "constraints" => [
                    new NotBlank(["message" => "L'url du site est obligatoire"])
                ]
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => "Description",
                'attr' => [
                    'placeholder' => 'Description',
                ],
                "constraints" => [
                    new NotBlank(["message" => "La description est obligatoire"])
                ]
            ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Audit::class
        ]);
    }

    // on modifie les paramettre (pour les rendre lisibles) dans l'url lors d'une recheche
    public function getBlockPrefix()
    {
        return '';
    }

    
}
