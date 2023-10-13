<?php


namespace App\Form;


use App\Entity\Secteur;
use App\Repository\SecteurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SecteurChoiceType extends AbstractType
{
    /**
     * @var SecteurRepository
     */
    private $secteurRepository;

    public function __construct(SecteurRepository $secteurRepository)
    {
        $this->secteurRepository = $secteurRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $secteurs = $this->secteurRepository->findBy(['active' => 1]);
        $builder
           ->add('secteur', EntityType::class, [
               'class' => Secteur::class,
               'choices' => $secteurs,
               'data' => $secteurs,

               'choice_label' => 'nom',
               'expanded' => true,
               'multiple' => true
           ]);
    }
}