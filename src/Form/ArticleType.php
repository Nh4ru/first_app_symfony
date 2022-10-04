<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\SubCategorie;
use App\Form\ArticleImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre : ',
                'required' => true
            ])
            ->add('categories', CategorieAutocompleteField::class, [
                'label' => 'Categories:',

            ])
            // ->add('subCategorie', EntityType::class, [
            //     'label' => 'Sous-Catégorie',
            //     'class' => SubCategorie::class,
            //     'multiple' => false,
            //     'expanded' => false,
            //     'choice_label' => true,
            // ])
            ->add('active', CheckboxType::class, [
                'label' => 'Active',
                'required' => false,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ArticleImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
                'by_reference' => false,
                'label' => false
            ])
            ->add('content', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}