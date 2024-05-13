<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Country;
use App\Entity\MetalStyle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un pays',
            ])
            ->add('picture', TextType::class, [
                'required' => false,
            ])
            ->add('style', EntityType::class, [
                'class' => MetalStyle::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un style',
            ])
            ->add('creationYear', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
