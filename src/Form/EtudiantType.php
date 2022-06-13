<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomComplet')
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('matricule')
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'masculin' => 1,
                    'Feminin' => 0
                ],

            ])
            ->add('adresse');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
