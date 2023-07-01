<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\UserRepository;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint;
use Lcobucci\JWT\Validation\ConstraintViolation;

class UserExistsConstraint implements Constraint
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function assert(Token $token): void
    {
        $serializedUser = $token->claims()->get('user');
        $user = json_decode($serializedUser, true, 512, JSON_THROW_ON_ERROR);

        if (!$this->userRepository->exists($user['id'])) {
            throw new ConstraintViolation('User not found');
        }
    }
}
