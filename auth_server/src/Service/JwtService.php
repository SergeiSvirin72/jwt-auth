<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;

class JwtService
{
    public function __construct(
        private Configuration $configuration,
        private int $tokenTtl,
        private array $permittedFor,
        private string $trustedIssuer,
    ) {
    }

    public function issue(User $user): UnencryptedToken
    {
        $now = new DateTimeImmutable();

        return $this->configuration->builder()
            ->issuedBy($this->trustedIssuer)
            ->permittedFor(...$this->permittedFor)
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($now->modify('+'.$this->tokenTtl.' seconds'))
            ->withClaim('id', $user->id)
            ->withClaim('user', json_encode($user->serialize(), JSON_THROW_ON_ERROR))
            ->getToken($this->configuration->signer(), $this->configuration->signingKey())
        ;
    }
}
