<?php

namespace App\Form;

use App\Services\CatalogueService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PackagePriceByTypeContratType extends AbstractType
{
     public function __construct(
        private CatalogueService $catalogueService,
        private SerializerInterface $serializer
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $typeContrats = $this->catalogueService->getTypeContrats();
        $typeContratChoices = array_reduce($typeContrats, function($carry, $item) {
            $carry[$item['label']] = $item['id'];
            return $carry;
        }, []);
        $builder
           ->add('price', IntegerType::class, [
                'label' => 'Prix',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Champ obligatoire']),
                    new Positive()
                ]
            ])
            ->add('typeContrat', ChoiceType::class, [
                "label" => "Type contrat",
                'choices' => $typeContratChoices,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Type contrat obligatoire"])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'isEdit' => false,
        ]);
    }
}
