<?php

namespace App\Form;

use App\Entity\CallScript;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CallScriptFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Intitulé',
                'trim' => true,
                'required' => false
            ])
            ->add('content', CKEditorType::class,  array(
            'required' => true,
            'config' => array(
                    'uiColor' => '#ffffff',
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CallScript::class,
        ]);
    }
}
