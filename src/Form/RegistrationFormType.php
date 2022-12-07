<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,[
                'label'=>'Nom',
                'attr'=>['class' => 'form-control'],
                ])
            ->add('Prenom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Prenom',
                'attr'=>[
                    'class' => 'form-control'
                ]])
            ->add('Sexe',ChoiceType::class,array(
                'choices'=>['homme'=>'homme','femme'=>'femme'],
                'expanded'=>true,
            ))
            ->add('NumTel',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'NumTel',
                'attr'=>['class' => 'form-control'],
            ])
            ->add('Cin',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Cin',
                'attr'=>['class' => 'form-control'],
            ])
            ->add('Adresse',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Adresse',
                'attr'=>['class' => 'form-control'],
            ])
            ->add('Role',ChoiceType::class,array(
                'choices'=>['user_role'=>'ROLE_USER'],
                'attr'=>['class' => 'form-control'],

            ))
            ->add('MotPasse',PasswordType::class,
                ['label'=>'MotPasse',

                    'attr'=>['class' => 'form-control'],
                ])
             ->add('submit',SubmitType::class,
                 [

                     'attr'=>['class' => 'btn bg-gradient-info w-100 mt-4 mb-0-control'],
                 ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}