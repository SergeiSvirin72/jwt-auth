<?php

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    'settings' => [
        'jwt' => [
            'ttl' => 5 * 60,
            // Указать сервисы, которые могут парсить токен
            'permitted_for' => ['http://localhost:8081'],
            // Указать авторизационный сервер, который выпускает токены
            'trusted_issuer' => 'http://localhost:8080',
            'private_key' => __DIR__ . '/../key/private.key',
            'passphrase' => 'passphrase',
        ],
    ]
]);
