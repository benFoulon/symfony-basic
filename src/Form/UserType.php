<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\SchoolYear;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles')
            ->add('password')
            ->add('firstname')
            ->add('lastname')
            ->add('phone')
            ->add('projects', EntityType::class, [
                'class' => Project::class,
                'choice_label' => function($project) {
                    return "{$project->getName()} ({$project->getId()})";
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('schoolYear', EntityType::class, [
                'class' => SchoolYear::class,
                'choice_label' => function($schoolYear) {
                    return "{$schoolYear->getName()} ({$schoolYear->getId()})";
                },
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
