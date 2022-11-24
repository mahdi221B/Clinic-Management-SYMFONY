<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\TypeEvenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('lieu')
            ->add('nom_organisateur')
            ->add('email_organisateur')
            ->add('phone_organisateur')
            ->add('date_debut')
            ->add('date_fin')
            ->add('montant_recole')
            ->add('typeEvenement',EntityType::class,array(
                'class'=>TypeEvenement::class,
                'choice_label'=>'nom'
            ))
            ->add('submit',SubmitType::class)
           // ->add('sponsors')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
