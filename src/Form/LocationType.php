<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null , [
                'attr' => [
                    'placeholder' => 'Enter city name',
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Poland' => 'PL',
                    'Germany' => 'GE',
                    'France' => 'FR',
                    'Spain' => 'ES',
                    'United States' => 'US',
                    'Italy' => 'IT',
                    'Ukraine' => 'UA',
                ],
            ])
            ->add('latitude', NumberType::class, [
                'attr' => [
                    'min' => -90,
                    'max' => 90,
                    'step' => 'any',
                ],
            ])
            ->add('longitude', NumberType::class, [
                'attr' => [
                    'min' => -90,
                    'max' => 90,
                    'step' => 'any',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
