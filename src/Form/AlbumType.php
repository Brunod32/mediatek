<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Band;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('releasedYear', TextType::class)
            ->add('albumCover', TextType::class, [
                'required' => false,
            ])
            ->add('band', EntityType::class, [
                'choice_label' => 'name',
                'class' => Band::class,
                'multiple'=> false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
