<?php


namespace App\Form;

use App\Entity\CategorieFormation;
use App\Entity\Formation;
use App\Util\Status;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuizFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'trim' => true,
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => "Titre obligatoire"]),
                ]
            ])
            ->add('description', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#cccccc',
                ],
                'required' => true,
            ])
            ->add('CategorieFormation', EntityType::class, [
                'placeholder' => 'Catégorie',
                'label' => false,
                'class' => CategorieFormation::class,
                'choice_label' => 'nom',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.statut = :statusValid')
                        ->setParameter('statusValid', Status::VALID)
                        ->orderBy('c.ordreCatFormation','ASC')
                    ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
            'method' => 'POST',
        ]);
        
    }
}
