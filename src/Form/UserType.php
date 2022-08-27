<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'image_uri' => true,
                'label' => 'Image : '
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom : ',
                'required' => true
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prenom : ',
                'required' => true
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Age : ',
                'required' => true
            ])
            ->add('mail', EmailType::class, [
                'label' => 'Mail : ',
                'required' => true
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password : ',
                'required' => true
            ])
            ->add('username', TextType::class, [
                'label' => 'Username : ',
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}