<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Type\RolesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter Username'
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter Email'
                ]
            ])
            ->add('password', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter Password'
                ]
            ])
            ->add('isActive')
            ->add('roles', RolesType::class, [
                'placeholder' => 'Choose a role option',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}