<?php

namespace App\Security;

use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
//        private AccessTokenRepository $repository
    ) {
    }

    /**
     * @throws \Exception
     */
    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        dd($accessToken);

        // e.g. query the "access token" database to search for this token
//        $accessToken = $this->repository->findOneByValue($accessToken);
//
//        if (null === $accessToken || !$accessToken->isValid()) {
//            throw new \Exception('Invalid credentials.');
//        }

        // and return a UserBadge object containing the user identifier from the found token
        return new UserBadge(3);
    }
}