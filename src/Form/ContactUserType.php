<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class ContactUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Entrez votre nom',
            'attr' => [
                'placeholder' => 'votre nom'
            ],
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ])
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Entrez votre prénom',
            'attr' => [
                'placeholder' => 'votre prénom'
            ],
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ])
        ])
        ->add('email', EmailType::class, [
            'label' => 'Entrez votre email',
            'attr' => [
                'placeholder' => 'votre email'
            ],
            'constraints' => new Email([
                'message' => 'Cette email {{value}} n\' est pas valide'
            ])
        ])
        ->add('message', TextareaType::class, [
            'label' => 'Entrez votre message',
            'attr' => [
                'placeholder' => 'votre message'
            ],
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                'class' => 'btn btn-success my-4'
            ]
        ])
;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
