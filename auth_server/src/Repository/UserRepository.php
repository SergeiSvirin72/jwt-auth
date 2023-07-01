<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;

class UserRepository
{
    /**
     * @var User[]
     */
    private array $users;

    public function __construct()
    {
        $this->users = [
            new User(1, 'sergei@first.ru', password_hash('1234', null)),
            new User(2, 'sergei@second.ru', password_hash('1234', null)),
            new User(3, 'sergei@third.ru', password_hash('1234', null)),
        ];
    }

    public function findOneByEmail(string $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->email === $email) {
                return $user;
            }
        }

        return null;
    }
}
