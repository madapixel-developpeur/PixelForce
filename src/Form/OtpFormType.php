<?php

namespace App\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class OtpFormType extends AbstractType
{
    public function __construct(private TranslatorInterface $translator)
    {
        
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('otpValue', TextType::class, [
                "label" => $this->translator->trans("Code de sécurité"),
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => $this->translator->trans("Code de sécurité obligatoire")]),
                ]
            ]);
        
            
            $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
            $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostData']);


    }

    public function onPreSubmit(FormEvent $event)
    {
        
    }

    public function onPostData(FormEvent $event)
    {
        
       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
