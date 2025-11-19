<?php

namespace App\Controller;

use App\DTO\LoginRequest;
use App\DTO\RegisterRequest;
use App\Repository\UserRepository;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/auth', name: 'api_auth_')]
class AuthController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private UserService $userService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager
    ) {
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        try {
            /** @var RegisterRequest $registerRequest */
            $registerRequest = $this->serializer->deserialize(
                $request->getContent(),
                RegisterRequest::class,
                'json'
            );

            $result = $this->userService->register($registerRequest);

            if (!$result['success']) {
                return new JsonResponse($result, Response::HTTP_BAD_REQUEST);
            }

            return new JsonResponse($result, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Wystąpił błąd podczas rejestracji',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        try {
            /** @var LoginRequest $loginRequest */
            $loginRequest = $this->serializer->deserialize(
                $request->getContent(),
                LoginRequest::class,
                'json'
            );

            // Validate request
            $errors = $this->validator->validate($loginRequest);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
                return new JsonResponse([
                    'success' => false,
                    'errors' => $errorMessages
                ], Response::HTTP_BAD_REQUEST);
            }

            // Find user
            $user = $this->userRepository->findOneByEmail($loginRequest->email);
            if (!$user) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Nieprawidłowy email lub hasło'
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Verify password
            if (!$this->passwordHasher->isPasswordValid($user, $loginRequest->password)) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Nieprawidłowy email lub hasło'
                ], Response::HTTP_UNAUTHORIZED);
            }

            // Generate JWT token
            $token = $this->jwtManager->create($user);

            return new JsonResponse([
                'success' => true,
                'message' => 'Logowanie zakończone pomyślnie',
                'token' => $token,
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'city' => $user->getCity(),
                    'postalCode' => $user->getPostalCode(),
                    'role' => $user->getRole()->value,
                ]
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Wystąpił błąd podczas logowania',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

