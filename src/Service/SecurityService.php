<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class SecurityService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly AuthenticationUtils $authenticationUtils,
        private readonly Security $security,
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

    public function auth(UserDto $userDto): User
    {
        $user = $this->userRepository->findOneBy(['email' => $userDto->getEmail()]);

//        $passwordCredentials = new PasswordCredentials($userDto->getPassword());
//        $passport = new Passport(new UserBadge($userDto->getEmail()), $passwordCredentials);

        if ($this->userPasswordHasher->isPasswordValid($user, $userDto->getPassword())){

//            $this->security->login($user);
//            $this->authenticationUtils->getLastUsername()
            dd('valid');
        }

        dd($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        return $user;
    }


    /**
     * @throws Exception
     */
    private function userExists(string $email): void
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user){
            throw new Exception('User exists with email: ' . $email);
        }
    }
}