<?php

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    'settings' => [
        'jwt' => [
            'public_key' => __DIR__ . '/../key/public.pem',
        ],
    ]
]);
