<?php

namespace App\Form;

use App\Entity\Produit;
use App\Repository\RessourceRubriqueRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use App\Entity\Ressource;
use App\Entity\RessourceRubrique;
use Symfony\Component\Validator\Constraints\File;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotNull;

class RessourceFormType extends AbstractType
{

    public function __construct(private RessourceRubriqueRepository $ressourceRubriqueRepository){}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $rubriques = $this->ressourceRubriqueRepository->createQueryBuilder('r')
        ->where('r.status = 1 and (r.secteur = :secteur or r.secteur is null)')
        ->setParameter('secteur', $options['secteur'])->getQuery()->getResult();
        $builder
            ->add('name', TextType::class, [
                "label" => "Titre",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Nom obligatoire"])
                ]
            ])
            // ->add('content', CKEditorType::class, [
            //     "label" => "Description",
            //     "required" => false,
            //     'config' => array(
            //         'uiColor' => '#ffffff',
            //         //'uiColor' => '#7367f0',
            //     )
            // ])
            ->add('content', TextareaType::class, [
                "label" => "Description",
                "required" => false,
            ])
            ->add('imageCover', HiddenType::class, [
                "label" => "Image de couverture",
                "required" => true,
                'trim' => true,
                "constraints" => [
                    new NotBlank(["message" => "Image de couverture obligatoire"])
                ]
            ])
            ->add('type', ChoiceType::class, [
                "label" => "Type",
                'choices' => [
                    Ressource::TYPE_LABEL[Ressource::TYPE_PROFESSIONNEL] => Ressource::TYPE_PROFESSIONNEL,
                    Ressource::TYPE_LABEL[Ressource::TYPE_REVENDEUR] => Ressource::TYPE_REVENDEUR
                ],
                "required" => false,
            ])
            ->add('rubrique', EntityType::class, [
                'label' => 'Rubrique',
                'class' => RessourceRubrique::class,
                'choice_label' => 'name',
                'choices' => $rubriques,
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ressource::class,
            'secteur' => null
        ]);
    }
}
