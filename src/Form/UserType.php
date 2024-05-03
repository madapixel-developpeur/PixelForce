<?php

namespace App\Form;

use App\Entity\User;
use App\Services\DirectoryManagement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\NotNull;

class UserType extends AbstractType
{
    /**
     * @var DirectoryManagement
     */
    private $directoryManagement;

    public function __construct(DirectoryManagement $directoryManagement)
    {
        $this->directoryManagement = $directoryManagement;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User $user */
        $user = $builder->getData();
//        dd($this->directoryManagement->getMediaFolder_User().DIRECTORY_SEPARATOR.$user->getPhoto());
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ],
                'required' => false,
                'label' => 'Prénom'
            ])
            ->add('lienCalendly', UrlType::class, [
                'attr' => [
                    'placeholder' => 'Liens calendly'
                ],
                'required' => false,
                'label' => 'Liens calendly'
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr'   => [
                    'placeholder' => 'aaaa-mm-dd'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'placeholder' => 'Votre Adresse'
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Numéro téléphone'
                ],
                'constraints' => [
                    new NotNull([],'champ obligatoire')
                ]
            ])
            ->add('numeroSecurite', TextType::class, [
                'attr' => [
                    'placeholder' => 'XXXXXXXXXX'
                ],
                'label' => 'Numéro de sécurité'
            ])
            ->add('rib', TextType::class, [
                'label' => 'RIB',
                'attr' => [
                    'placeholder' => 'XXXXXXXXXX'
                ]
            ])
            ->add('photo', FileType::class, [
                'required' => false,
                'data_class' => null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
