<?php


namespace App\Form;

use App\Entity\UserTransaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            ->add('rib', TextType::class, [
                'label' => 'RIB',
                'attr' => [
                    'placeholder' => 'Votre RIB'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
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
