<?php


namespace App\Form;

use App\Entity\FormationQuizItem;
use App\Entity\FormationQuizItemChoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizItemChoiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('choix', TextareaType::class, [
                'label' => 'Choix',
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => "Choix obligatoire"]),
                ]
            ])
            ->add('vrai', CheckboxType::class, [
                'label'    => 'Est une bonne réponse ?',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationQuizItemChoice::class,
            'method' => 'POST',
        ]);
        
    }
}
