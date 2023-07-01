<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\UserRepository;
use App\Util\ResponseGenerator;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProfileHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private ResponseGenerator $responseGenerator,
    ) {
    }

    public function profile(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $userId = $request->getAttribute('user_id');
        $user = $this->userRepository->find($userId);

        if (null === $user) {
            throw new Exception('User not found');
        }

        return $this->responseGenerator->json($response, $user->serialize());
    }
}
