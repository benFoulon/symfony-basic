<?php

namespace App\Form;

use App\Entity\SchoolYear;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SchoolYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dateStart', DateType::class, [
                'widget' => 'slingle_text',
                // 'format' => 'dd/MM/yy',
                // 'html5' => false,
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'slingle_text',
            ])
            ->add('users', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => function ($user) {
                    return "{$user->getFirstName()} {$user->getLastName()} ({$user->getId()})";
                },
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SchoolYear::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
