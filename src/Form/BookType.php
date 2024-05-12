<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Writer;
use App\Entity\LiteraryStyle;
use App\Repository\WriterRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('nbPages', IntegerType::class)
            ->add('bookCover', TextType::class, [
                'required' => false,
            ])
            ->add('synopsis', TextareaType::class)
            ->add('writer', EntityType::class, [
                'choice_label' => 'lastname',
                'class' => Writer::class,
                'multiple'=> false,
                'expanded' => false,
                'placeholder' => 'Sélectionnez un auteur',
                // affiche les options du select par ordre alphabétique
                'query_builder' => function(WriterRepository $writerRepository) {
                    return $writerRepository
                        ->createQueryBuilder('w')
                        ->orderBy('w.lastname', 'ASC');
                }
            ])
            ->add('releasedYear', TextType::class)
            ->add('style', EntityType::class, [
                'class' => LiteraryStyle::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un style littéraire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
