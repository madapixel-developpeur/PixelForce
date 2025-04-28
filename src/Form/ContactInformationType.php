<?php

namespace App\Form;

use App\Entity\TypeLogement;
use App\Entity\ContactInformation;
use Symfony\Component\Form\AbstractType;
use App\Repository\TypeLogementRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactInformationType extends AbstractType
{
    private $typeLogementRepository;
    public function __construct(
        TypeLogementRepository $typeLogementRepository,
        private TranslatorInterface $translator,
    )
    {
        $this->typeLogementRepository = $typeLogementRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $contactInformation = $builder->getData();
        $contact = $contactInformation->getContact();
        $typeLogementList = $this->typeLogementRepository->findAll();
        $translatedContactLabel = [];
        foreach( ContactInformation::TYPE_CONTACT_LABELS as $key => $value){
            $translatedContactLabel[$this->translator->trans($key)] = $value ; 
        }

        $builder
            ->add('firstname', TextType::class, [
                'label' => $this->translator->trans('Prénom'),
                'attr' => [
                    'placeholder' => $this->translator->trans('Entrer le prénom')
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' =>$this->translator->trans('Nom') ,
                'attr' => [
                    'placeholder' =>$this->translator->trans('Entrer le nom') 
                ]
            ])
            ->add('email', TextType::class, [
                'label' =>$this->translator->trans('E-mail') ,
                'attr' => [
                    'placeholder' => $this->translator->trans('Entrer l\'adresse mail')
                ]
            ])
            ->add('phone', TextType::class, [
                'label' =>$this->translator->trans('Téléphone') ,
                'attr' => [
                    'placeholder' =>$this->translator->trans('Entrer le numéro téléphone') 
                ]
            ])
            ->add('address', TextType::class, [
                'label' =>$this->translator->trans('Adresse') ,
                'attr' => [
                    'placeholder' =>$this->translator->trans('Entrer l\'adresse') 
                ]
            ])
            ->add('rue', TextType::class, [
                'label' =>$this->translator->trans('Rue') ,
                'trim' => true,
                'required' => false
            ])
            ->add('numero', TextType::class, [
                'label' => $this->translator->trans('Numéro'),
                'trim' => true,
                'required' => false
            ])
            ->add('codePostal', TextType::class, [
                'label' =>$this->translator->trans('Code postal') ,
                'trim' => true,
                'required' => false
            ])
            ->add('ville', TextType::class, [
                'label' => $this->translator->trans('Ville'),
                'trim' => true,
                'required' => false
            ])
            ->add('typeLogement', EntityType::class, [
                "label" =>$this->translator->trans( "Type du Logement"),
                'class' => TypeLogement::class,
                'choices' => $typeLogementList,
                'choice_label' => function (?TypeLogement $typeLogement) {
                    return $typeLogement ? $typeLogement->getNom() : '';
                },
                'multiple' => false,
                'expanded' => true,
                "required" => false,
                'placeholder' => false,
                'attr' => [
                    'class' => 'd-flex align-items-center choices-radio',
                ],
            ])
            ->add('nbrPersonne', IntegerType::class, [
                'label' => $this->translator->trans('Nombre de personnes du foyer'),
                'required' => false
            ])
            ->add('note', TextareaType::class, [
                'required' => false,
                'label' =>$this->translator->trans( 'Note'),
                'mapped' => false,
                'data' => $contact ? $contact->getNote() : '',
                'attr' => [
                    "rows" => 10
                ]
            ])
            ->add('type', ChoiceType::class, [
                "label" => $this->translator->trans("Type du contact"),
                'choices' => array_flip(ContactInformation::TYPE_ARRAY_FORM),
                'required' => true,
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('typeContact', ChoiceType::class, [
                "label" => $this->translator->trans("Type"),
                'choices' => ContactInformation::TYPE_CONTACT_LABELS,
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'data' => $contact?->getInformation()?->getTypeContact() ?? ContactInformation::TYPE_CONTACT_PARTICULIER,
                'attr' => [
                    'class' => 'd-flex align-items-center choices-radio',
                ],
            ])
            ->add('anneeConstructionMaison', IntegerType::class, [
                'label' => $this->translator->trans('Année de construction de la maison'),
                'required' => false
            ])
            ->add('nomEntreprise', TextType::class, [
                'label' => $this->translator->trans('Nom de l\'entreprise'),
                'trim' => true,
                'required' => false
            ])
            ->add('siretEntreprise', TextType::class, [
                'label' => $this->translator->trans('Siret'),
                'trim' => true,
                'required' => false
            ])
            ->add('adresseEntreprise', TextType::class, [
                'label' => $this->translator->trans('Adresse postale (rue, ville, code postal, pays)'),
                'trim' => true,
                'required' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactInformation::class,
        ]);
    }
}
