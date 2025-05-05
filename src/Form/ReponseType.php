<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReponseType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator,
    )
    {
      
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => false,
                'label' => $this->translator->trans('Titre de la réponse'),
                'constraints' =>[
                    new NotBlank([
                        'message' => $this->translator->trans('Le titre de problème  est obligatoire'),
                    ]),
                ],
                'attr' => [
                    'placeholder' => $this->translator->trans('Titre de la réponse'),
                ]
            ])
            
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => $this->translator->trans("Description") ,
                'constraints' =>[
                    new NotBlank([
                        'message' => $this->translator->trans('La description  est obligatoire') ,
                    ]),
                ],
                'attr' => [
                    'placeholder' => $this->translator->trans('Description') ,
                ]
            ])    
            ->add('fichier', FileType::class, [
                "label" => "Fichier ",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        // 'maxSize' => '1024k',
                        'mimeTypesMessage' => $this->translator->trans('Image invalide. Le format doit être: .jpeg ou .png'),
                    ])
                ]
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class
        ]);
    }

    // on modifie les paramettre (pour les rendre lisibles) dans l'url lors d'une recheche
    public function getBlockPrefix()
    {
        return '';
    }

    
}
