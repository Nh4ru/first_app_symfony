<?php

namespace App\Form;

use App\Entity\User;
use App\Data\SearchData;
use App\Entity\Categorie;
use App\Entity\SubCategorie;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Categorie::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.enable = true')
                        ->orderBy('c.titre', 'ASC');
                },
                'choice_label' => 'titre',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('subCategories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => SubCategorie::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('sc')
                        ->andWhere('sc.enable = true')
                        ->orderBy('sc.titre', 'ASC');
                },
                'choice_label' => 'titre',
                'multiple' => true,
                'expanded' => true
            ])
            ->add(
                'author',
                EntityType::class,
                [
                    'label' => false,
                    'required' => false,
                    'class' => User::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->join('u.articles', 'a')
                            ->orderBy('u.nom', 'ASC');
                    },
                    'multiple' => true,
                    'expanded' => true

                ]
            )
            ->add('active', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    'oui' => true,
                    'non' => false
                ],
                'multiple' => true,
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    /**
     * Nettoyer l'url
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}