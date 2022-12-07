<?php

namespace App\Form;

use App\Entity\Examen;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medecin')
            ->add('patient')
            ->add('salle')
            ->add('typeEx',ChoiceType::class, options: array(
                'choices' => array(
                    'Bilan'=> 'Bilan',
                    'Test Covid'=> 'Test Covid',
                    'panoramique'=> 'panoramique',
                    'Test radiologie'=> 'Test radiologie',
                )))
           ->add('dateEx')
            ->add('resEx',ChoiceType::class, options: array(
        'choices' => array(
            'positif "+" '=> 'positif + ',
            'négatif "-" '=> 'négatif - ',
        ),'expanded'=>true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Examen::class,
        ]);
    }
}
