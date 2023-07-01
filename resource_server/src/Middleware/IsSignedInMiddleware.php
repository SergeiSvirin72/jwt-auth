<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Service\JwtService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IsSignedInMiddleware implements MiddlewareInterface
{
    public function __construct(
        private JwtService $jwtService,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $header = $request->getHeader('Authorization');
        if (!isset($header[0])) {
            return $this->responseFactory->createResponse()->withStatus(401);
        }

        $token = $this->jwtService->parse(substr($header[0], 7));
        $this->jwtService->validate($token);

        $userId = $token->claims()->get('id');
        $request = $request->withAttribute('user_id', $userId);

        return $handler->handle($request);
    }
}
