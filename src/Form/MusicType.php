<?php

namespace App\Form;

use App\Entity\Music;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class MusicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'download_uri' => false,
                'label' => 'Musique : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Music::class,
        ]);
    }
}