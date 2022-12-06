<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Articles;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('QteC')
            //->add('status')
       //   ->add('date_ajout')
            //->add('date_cloture')
            //->add('motif_cloture')
            //->add('articless')
        /*    ->add('articles',EntityType::class,array(
                'class'=>Articles::class,
                'choice_label'=>'nom_articles'

            ))*/
            ->add("commander",SubmitType::class)

        ;     }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
