<?php

namespace App\Form;

use App\Entity\SubCategorie;
use App\Repository\SubCategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class SubCategorieAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => SubCategorie::class,
            'placeholder' => 'Choisir une sous-catégorie',
            'choice_label' => 'titre',
            'multiple' => true,

            'query_builder' => function (SubCategorieRepository $subCategorieRepository) {
                return $subCategorieRepository->createQueryBuilder('c')
                    ->andWhere('c.enable = true')
                    ->orderBy('c.titre', 'ASC');
            },
            'by_reference' => false,
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}