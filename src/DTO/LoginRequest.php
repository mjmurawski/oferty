<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class LoginRequest
{
    #[Assert\NotBlank(message: 'Email jest wymagany')]
    #[Assert\Email(message: 'Email jest nieprawidłowy')]
    public ?string $email = null;

    #[Assert\NotBlank(message: 'Hasło jest wymagane!')]
    public ?string $password = null;
}

