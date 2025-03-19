<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => " Votre prénom",
                'attr' => [
                    'placeholder' => "Entrez votre prénom"
                ]
            ])
            ->add('nom', TextType::class, [
                'label' => " Votre nom",
                'attr' => [
                    'placeholder' => "Entrez votre nom"
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => " Votre adresse",
                'attr' => [
                    'placeholder' => "Entrez votre adresse"
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => " Votre code postal",
                'attr' => [
                    'placeholder' => "Entrez votre code postal"
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => " Votre ville",
                'attr' => [
                    'placeholder' => "Entrez votre ville"
                ]
            ])
            ->add('pays', CountryType::class, [
                'label' => " Votre pays"
            ])
            ->add('phone', TextType::class, [
                'label' => " Votre téléphone",
                'attr' => [
                    'placeholder' => "Entrez votre téléphone"
                ]
            ])
            ->add('Submit', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => [
                    'class' => 'btn btn-success my-4'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
