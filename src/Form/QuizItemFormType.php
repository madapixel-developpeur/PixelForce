<?php


namespace App\Form;

use App\Entity\FormationQuizItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizItemFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question', TextareaType::class, [
                'label' => 'Question',
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => "Question obligatoire"]),
                ]
            ])
            ->add('multipleChoix', CheckboxType::class, [
                'label'    => 'Est ce une question à choix multiple ?',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormationQuizItem::class,
            'method' => 'POST',
        ]);
        
    }
}
