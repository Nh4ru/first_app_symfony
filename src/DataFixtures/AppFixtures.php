<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setPrenom('Tristan')
            ->setNom('Fernandez')
            ->setAge(33)
            ->setUsername('Tristan-Fernandez')
            ->setMail('tristan-Fernandez@example.com')
            ->setPassword('(Bass-Pearl1989)')
            //->setImageName('image1')

            // Nouvelle methode avec PHP 8
            //->setPassword($this->hasher->hashPassword($user, '(Bass-Pearl1989)'))

            ->setRoles(['ROLE_ADMIN'])
            ->setVille('Valence');

        $manager->persist($user);
        $manager->flush();
    }
}