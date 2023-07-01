<?php

declare(strict_types=1);

namespace App\Util;

use Psr\Http\Message\ResponseInterface;

class ResponseGenerator
{
    public function json(ResponseInterface $response, array $body): ResponseInterface
    {
        $response->getBody()->write(json_encode($body, JSON_THROW_ON_ERROR));

        return $response;
    }
}
