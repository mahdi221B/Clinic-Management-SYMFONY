<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_articles')
            ->add('qte')
            ->add('description')
            ->add('type',ChoiceType::class, [
                'choices'  => [
                    'medicament' => "medicament",
                    'equipement' => "equipement",
                ]],)
            ->add('a_qui_destine',ChoiceType::class, [
                'choices'  => [
                    'enfant' => "enfant",
                    'adulte' => "adulte",
                     'tous' => "tous",
                ]],)
            ->add('prix')
            //->add('commandes')
            ->add("ajouterarticles",SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
