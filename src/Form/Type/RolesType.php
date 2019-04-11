<?php
/**
 * Created by PhpStorm.
 * User: jabrane
 * Date: 09/04/2019
 * Time: 18:46
 */

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RolesType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'choices'=>User::ROLES,
                'multiple' => true,/*
                'expanded'=>true,*/
            ]
        );
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

}