<?php

namespace App\Form;

use App\DTO\PackageTypeDTO;
use App\Util\Search\Constants;
use App\Services\CatalogueService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PackageFormType extends AbstractType
{
    public function __construct(
        private CatalogueService $catalogueService,
        private SerializerInterface $serializer
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $packageTypeList = $this->catalogueService->getTypePackages();
        $services = $this->catalogueService->getAllExistingServiceName();
        $services = array_column($services, 'service');

        $packageTypeDTOs = $this->serializer->denormalize(
            $packageTypeList,
            PackageTypeDTO::class . '[]'
        );

        $builder
            ->add('name', TextType::class, [
                "label" => "Nom",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Champ obligatoire"])
                ]
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Montant',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Champ obligatoire']),
                    new Range([
                        'min' => 0.01,
                        'max' => 99999999.99,
                        'notInRangeMessage' => 'Le montant doit être entre {{ min }} et {{ max }}.',
                    ])
                ],
                'attr' => [
                    'min' => 0.01,
                    'max' => 99999999.99,
                    'step' => '0.01',
                ]
            ])
            ->add('service', TextType::class, [
                "label" => "Service",
                "trim" => true,
                "required" => false,
                "constraints" => [
                    new NotBlank(["message" => "Champ obligatoire"])
                ]
            ])
            ->add('period', ChoiceType::class, [
                "label" => "Récurrence",
                "required" => false,
                "choices" => Constants::PACKAGE_PERIOD
            ])
            ->add('bv', IntegerType::class, [
                'label' => 'BV',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Champ obligatoire']),
                ]
            ])
            ->add('service', ChoiceType::class, [
                "label" => "Service",
                "required" => true,
                "choices" => array_combine( $services,  $services),
                "constraints" => [
                    new NotBlank(["message" => "Champ obligatoire"])
                ]
            ])
            ->add('packageType', ChoiceType::class, [
                "label" => "Type du package",
                'choices' => $packageTypeDTOs,
                'choice_label' => fn(?PackageTypeDTO $packageType) => $packageType ? strtoupper($packageType->getName()) : '',
                'choice_value' => fn(?PackageTypeDTO $packageType) => $packageType?->getId(),
                'required' => true,
                'constraints' => [
                    new NotBlank(["message" => "Type du package obligatoire"]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'isEdit' => false,
            'data_class' => null
        ]);
    }
}
