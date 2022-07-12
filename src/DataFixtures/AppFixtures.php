<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
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
            ->setRoles(['ROLE_ADMIN'])
            ->setVille('Valence');

        $manager->persist($user);
        $manager->flush();
    }
}
