<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Service\SecurityService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly SecurityService $securityService,
    ){}

    /**
     * @throws Exception
     */
    #[Route('/registry', name: 'registry', methods: "POST")]
    public function registry(Request $request): JsonResponse
    {
        $userDto = $this->serializer->deserialize($request->getContent(), UserDto::class, 'json');

        $errors = $this->validator->validate($userDto);

        if (count($errors) > 0) {
            throw new BadRequestException($errors->get(0)->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $user = $this->securityService->createUser($userDto);

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ]);
    }
}
