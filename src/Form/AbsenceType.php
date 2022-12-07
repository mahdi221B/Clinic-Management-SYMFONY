<?php

namespace App\Form;

use App\Entity\Absence;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AbsenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user',EntityType::class,array(
                'class'=>User::class,
                'choice_label'=>'nom'))
            ->add('DateAbsence')
            ->add('DureAbsence',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'DureAbsence',
                'attr'=>[
                    'placeholder'=>'Dure de Absence'
                ]])
            ->add('Justification',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Justification',
                'attr'=>[
                    'placeholder'=>'Justification'
                ]])
          //  ->add('Ajout',SubmitType::class)
        ;
    }







    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Absence::class,
        ]);
    }
}
