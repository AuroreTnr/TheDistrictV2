<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualpassword', PasswordType::class, [
                'label' => 'Entrez votre mot de passe actuel',
                'attr' => [
                    'placeholder' => 'Entrez votre mot de passe actuel',
                    'class' => 'mb-3'
                ],
                'mapped' => false,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Choisissez votre nouveau mot de passe',
                    'hash_property_path' => 'password',
                    'attr' => [
                        'placeholder' => 'Entrez votre nouveau mot de passe',
                        'class' => 'mb-3'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre nouveau mot de passe',
                    ]
                ],
                'mapped' => false,
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event): void {
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordhasher = $form->getConfig()->getOptions()['passwordhasher'];

                $isValid = $passwordhasher->isPasswordValid($user, $form->get('actualpassword')->getData());

                if (!$isValid) {
                    $form->get('actualpassword')->addError(new FormError("Votre mot de passe n' est pas correcte, veuillez réessayer."));
                }
            })        

            ->add('Submit', SubmitType::class, [
                'label' => 'Modifier mon mot de passe',
                'attr' => [
                    'class' => 'btn btn-success my-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordhasher' => Null,
        ]);
    }
}
