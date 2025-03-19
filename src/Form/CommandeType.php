<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Transporteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresses', EntityType::class, [
                'label' => 'Choissiez votre adresse de livraison',
                'required' => true,
                // Attention ici c est bien ::class et pas attribut class=""
                'class' => Adresse::class,
                'expanded' => true,
                // on recupere les adresses de notre utilisateur grace a $options
                'choices' => $options['adresses'],
                'label_html' => true,

            ])
            ->add('transporteur', EntityType::class, [
                'label' => 'Choissiez votre transporteur',
                'required' => true,
                'class' => Transporteur::class,
                'expanded' => true,
                // on recupere les transporteurs
                'label_html' => true,

            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => [
                    'class'=>"btn btn-outline-secondary w-100 my-3"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            // on doit mettre à null
            'adresses' => null,
        ]);
    }
}
