<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Evenement;
use App\Entity\TypeEvenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('lieu')
            ->add('user',EntityType::class,array(
                'class'=>User::class,
                'choice_label'=>'nom',
                'autocomplete' => true
            ))
            //->add('nom_organisateur')
            //->add('email_organisateur')
            //->add('phone_organisateur')
            ->add('date_debut')
            ->add('date_fin')
            ->add('picture', DropzoneType::class, array('data_class' => null))
            ->add('typeEvenement',EntityType::class,array(
                'class'=>TypeEvenement::class,
                'choice_label'=>'nom',
                'autocomplete' => true
            ))
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
