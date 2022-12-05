<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Nom',
                'attr'=>[
                    'placeholder'=>'nom de utilisateur'
                ]])
            ->add('Prenom',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Prenom',
                'attr'=>[
                    'placeholder'=>'prenom de utilisateur'
                ]])
            ->add('Sexe',ChoiceType::class,array(
                'choices'=>['homme'=>'homme','femme'=>'femme'],
                'expanded'=>true,
            ))
            ->add('NumTel',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'NumTel',
                'attr'=>[
                    'placeholder'=>'numéro de utilisateur '
                ]])
            ->add('Cin',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Cin',
                'attr'=>[
                    'placeholder'=>'Cin de user'
                ]])
            ->add('Adresse',\Symfony\Component\Form\Extension\Core\Type\TextType::class,['label'=>'Adresse',
                'attr'=>[
                    'placeholder'=>'nom@exemple.com'
                ]])
            ->add('Role',ChoiceType::class,array(
                'choices'=>['Admin'=>'ROLE_ADMIN','Medecin'=>'ROLE_MEDECIN','infirmier'=>'ROLE_INFIRMIER','agent_stock'=>'ROLE_STOCK','secretaire'=>'ROLE_SECRETAIRE','technicien'=>'ROLE_TECHNICIEN'
                    ,'user_role'=>'ROLE_USER']
            ))
            ->add('MotPasse',PasswordType::class,
                ['label'=>'MotPasse',
                    'attr'=>[
                        'placeholder'=>'Mot de   Passe'
                    ]]
            )
           // ->add('Ajout',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
