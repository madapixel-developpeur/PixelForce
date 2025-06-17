<?php

namespace App\Form;

use App\Entity\PlatformIdentity;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;
use Gregwar\CaptchaBundle\Type\CaptchaType;

class PlatformIdentityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Adresse email",
                "trim" => true,
                "required" => true,
                'invalid_message' => 'Adresse email invalide',
                "constraints" => [
                    new NotBlank(["message" => "Adresse email obligatoire"])
                ]
            ])
            ->add('username', TextType::class, [
                "label" => "Nom d'utilisateur",
                "trim" => true,
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Nom d'utilisateur obligatoire"])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlatformIdentity::class,
            'signup' => false
        ]);
    }
}
