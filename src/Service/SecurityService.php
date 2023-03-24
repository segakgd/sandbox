<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function createUser(UserDto $userDto): User
    {
        $user = (new User());
        $password = $this->userPasswordHasher->hashPassword($user, $userDto->getPassword());

        $user->setEmail($userDto->getEmail());
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        return $user;
    }
}