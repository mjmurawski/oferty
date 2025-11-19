<?php

namespace App\Service;

use App\DTO\RegisterRequest;
use App\Entity\User;
use App\Entity\UserProfile;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ) {
    }

    public function register(RegisterRequest $registerRequest): array
    {
        // Validate request
        $errors = $this->validator->validate($registerRequest);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return ['success' => false, 'errors' => $errorMessages];
        }

        // Check if user already exists
        if ($this->userRepository->findOneByEmail($registerRequest->email)) {
            return ['success' => false, 'errors' => ['Użytkownik o podanym emailu już istnieje']];
        }

        // Create new user
        $user = new User();
        $user->setEmail($registerRequest->email);
        $user->setCity($registerRequest->city);
        $user->setPostalCode($registerRequest->postalCode);
        
        // Hash password
        $hashedPassword = $this->passwordHasher->hashPassword($user, $registerRequest->password);
        $user->setPasswordHash($hashedPassword);

        // Create user profile
        $userProfile = new UserProfile();
        $userProfile->setUser($user);
        $user->setUserProfile($userProfile);

        // Save to database
        $this->entityManager->persist($user);
        $this->entityManager->persist($userProfile);
        $this->entityManager->flush();

        return [
            'success' => true,
            'message' => 'Rejestracja zakończona pomyślnie',
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'city' => $user->getCity(),
                'postalCode' => $user->getPostalCode(),
            ]
        ];
    }
}

