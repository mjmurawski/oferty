<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterRequest
{
    #[Assert\NotBlank(message: 'Email jest wymagany')]
    #[Assert\Email(message: 'Email jest nieprawidłowy')]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'Hasło jest wymagane')]
    #[Assert\Length(min: 6, minMessage: 'Hasło musi mieć minimum 6 znaków')]
    public ?string $password = null;

    #[Assert\NotBlank(message: 'Miasto jest wymagane')]
    public ?string $city = null;

    #[Assert\NotBlank(message: 'Kod pocztowy jest wymagany')]
    public ?string $postalCode = null;
}

