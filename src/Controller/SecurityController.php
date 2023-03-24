<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Service\SecurityService;
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

    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SecurityController.php',
        ]);
    }

    #[Route('/registry', name: 'registry')]
    public function registry(Request $request): JsonResponse
    {
        $userDto = $this->serializer->deserialize($request->getContent(), UserDto::class, 'json');

        $errors = $this->validator->validate($userDto);

        if (count($errors) > 0) {
            throw new BadRequestException($errors->get(0)->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $user = $this->securityService->createUser($userDto);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SecurityController.php',
        ]);
    }
}
