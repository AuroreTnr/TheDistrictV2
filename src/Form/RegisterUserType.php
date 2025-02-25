<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
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
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Choisissez votre mot de passe',
                    'hash_property_path' => 'password',
                    'attr' => [
                        'placeholder' => 'Entrez votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre mot de passe'
                    ]
                ],
                'mapped' => false,
            ])            
            ->add('adresse',  TextType::class, [
                'label' => 'Entrez votre adresse',
                'attr' => [
                    'placeholder' => 'votre adresse'
                ]
            ])
            ->add('cp',  TextType::class, [
                'label' => 'Entrez votre code postal',
                'attr' => [
                    'placeholder' => 'votre code postal'
                ]
            ])
            ->add('ville',  TextType::class, [
                'label' => 'Entrez le nom de votre ville',
                'attr' => [
                    'placeholder' => 'votre ville'
                ]
            ])
            ->add('telephone',  TextType::class, [
                'label' => 'Entrez votre numéro de téléphone',
                'attr' => [
                    'placeholder' => 'votre téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-success mt-2'
                ]
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
