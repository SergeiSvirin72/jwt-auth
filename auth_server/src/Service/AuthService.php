<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;

class AuthService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function auth(string $email, string $password): User
    {
        $user = $this->userRepository->findOneByEmail($email);

        if (null === $user) {
            throw new Exception('User not found');
        }

        if (!password_verify($password, $user->password)) {
            throw new Exception('Invalid password');
        }

        return $user;
    }
}
