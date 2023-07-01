<?php

declare(strict_types=1);

namespace App\Handler;

use App\Service\AuthService;
use App\Service\JwtService;
use App\Util\ResponseGenerator;
use App\Validator\SignInValidator;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthHandler
{
    public function __construct(
        private SignInValidator $signInValidator,
        private AuthService $authManager,
        private JwtService $jwtService,
        private ResponseGenerator $responseGenerator,
    ) {
    }

    public function signIn(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        $error = $this->signInValidator->validate($body);

        if (null !== $error) {
            return $this->responseGenerator->json($response, ['error' => $error]);
        }

        try {
            $user = $this->authManager->auth($body['email'], $body['password']);
            $token = $this->jwtService->issue($user);
        } catch (Exception $exception) {
            return $this->responseGenerator->json($response, ['error' => $exception->getMessage()]);
        }

        return $this->responseGenerator->json($response, [
            'access_token' => $token->toString(),
            'refresh_token' => '',
        ]);
    }
}
