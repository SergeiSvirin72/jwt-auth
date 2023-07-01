<?php

declare(strict_types=1);

namespace App\Service;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\UnencryptedToken;

class JwtService
{
    public function __construct(private Configuration $configuration)
    {
    }

    public function parse(string $jwt): UnencryptedToken
    {
        return $this->configuration->parser()->parse($jwt);
    }

    public function validate(Token $token): void
    {
        $constraints = $this->configuration->validationConstraints();
        $this->configuration->validator()->assert($token, ...$constraints);
    }
}
