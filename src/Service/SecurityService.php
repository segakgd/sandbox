<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function createUser(UserDto $userDto): User
    {
        $user = (new User());

        $this->userExists($userDto->getEmail());

        $password = $this->userPasswordHasher->hashPassword($user, $userDto->getPassword());

        $user->setEmail($userDto->getEmail());
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        return $user;
    }

    /**
     * @throws Exception
     */
    private function userExists(string $email): void
    {
        $user = $this->userRepository->findBy(['email' => $email]);

        if ($user){
            throw new Exception('User exists with email: ' . $email);
        }
    }
}