<?php

use Psr\Container\ContainerInterface;

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    \Lcobucci\JWT\Configuration::class => function (ContainerInterface $c) {
        $settings = $c->get('settings')['jwt'];

        return \Lcobucci\JWT\Configuration::forAsymmetricSigner(
            new \Lcobucci\JWT\Signer\Rsa\Sha256(),
            \Lcobucci\JWT\Signer\Key\InMemory::file($settings['private_key'], $settings['passphrase']),
            \Lcobucci\JWT\Signer\Key\InMemory::plainText('empty'),
        );
    },
    \App\Service\JwtService::class => function (ContainerInterface $c) {
        $settings = $c->get('settings')['jwt'];

        return new \App\Service\JwtService(
            $c->get(\Lcobucci\JWT\Configuration::class),
            $settings['ttl'],
            $settings['permitted_for'],
            $settings['trusted_issuer'],
        );
    }
]);
