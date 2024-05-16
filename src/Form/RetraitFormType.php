<?php


namespace App\Form;

use App\Entity\UserTransaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class RetraitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', TextType::class, [
                'label' => 'Montant',
                'trim' => true,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrer le montant du retrait ici'
                ],
                'constraints' => [
                    new NotBlank(["message" => "Montant obligatoire"]),
                    new Positive(["message" => "Montant invalide"])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserTransaction::class,
            'method' => 'POST',
        ]);
    }
}
