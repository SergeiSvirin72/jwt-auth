<?php

namespace App\Entity;

use JetBrains\PhpStorm\ArrayShape;

class User
{
    public function __construct(
        public int $id,
        public string $email,
        public string $password
    ) {
    }

    #[ArrayShape(['id' => "int", 'email' => "string"])]
    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }
}
