<?php

namespace App\Fixtures\Provider;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProvider
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }


    public function hashPassword(string $plainPassword): String
    {
        return $this->hasher->hashPassword(new User(), $plainPassword);
    }
}