<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Module;
use App\Entity\Professeur;
use App\Entity\Rp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomComplet')
            ->add('grade')
            ->add('module', EntityType::class, array(
                'class' => Module::class,
                'choice_label' => function ($module) {
                    return $module->getLibelle();
                },
                'multiple' => true
            ))
            ->add('classe', EntityType::class, array(
                'class' => Classe::class,
                'choice_label' => function ($classe) {
                    return $classe->getLibelle();
                },
                'multiple' => true
            ))

            ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professeur::class,
        ]);
    }
}
