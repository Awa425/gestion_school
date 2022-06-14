<?php

namespace App\Form;

use App\Entity\AnneeScolaire;
use App\Entity\Classe;
use App\Entity\Inscription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etudiant', EtudiantType::class)
            ->add('classes', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => function ($classe) {
                    return $classe->getLibelle();
                },

            ])
            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
