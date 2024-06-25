<?php


namespace App\Form;

use App\Entity\UserTransaction;
use Symfony\Component\Form\AbstractType;
use Google\Service\PeopleService\Interest;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RetraitFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', IntegerType::class, [
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
                ],
                'data'  => $options['rib']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserTransaction::class,
            'method' => 'POST',
        ]);
        $resolver->setRequired('rib');
    }
}
