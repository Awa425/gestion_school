<?php

namespace App\Form;

use App\Entity\Ac;
use App\Entity\Rp;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomComplet')
            ->add('email', EmailType::class)
            ->add('password')
            ->add('rp', EntityType::class, array(
                'class' => Rp::class,
                'choice_label' => function ($rp) {
                    return $rp->getNomComplet();
                },
                'multiple' => false
            ))
            ->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ac::class,
        ]);
    }
}
