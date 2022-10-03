<?php

namespace App\Form;

use App\Entity\SubCategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

class SubCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'titre',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre de la sous-catégorie',
                ],
            ])
            ->add('color', ColorType::class, [
                'label' => 'Couleur de la sous-catégorie',
                'required' => true,
            ])
            ->add('categorie');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubCategorie::class,
        ]);
    }
}