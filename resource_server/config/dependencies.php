<?php

use Psr\Container\ContainerInterface;

/** @var \DI\ContainerBuilder $containerBuilder */

$containerBuilder->addDefinitions([
    \Lcobucci\JWT\Configuration::class => function (ContainerInterface $c) {
        $settings = $c->get('settings')['jwt'];

        $configuration = \Lcobucci\JWT\Configuration::forAsymmetricSigner(
            new \Lcobucci\JWT\Signer\Rsa\Sha256(),
            \Lcobucci\JWT\Signer\Key\InMemory::plainText('empty'),
            \Lcobucci\JWT\Signer\Key\InMemory::file($settings['public_key']),
        );

        $clock = new class implements \Psr\Clock\ClockInterface {
            public function now(): DateTimeImmutable
            {
                return new DateTimeImmutable();
            }
        };

        $configuration->setValidationConstraints(
            new \Lcobucci\JWT\Validation\Constraint\SignedWith(
                new \Lcobucci\JWT\Signer\Rsa\Sha256(),
                \Lcobucci\JWT\Signer\Key\InMemory::file($settings['public_key']),
            ),
            $c->get(\App\Service\UserExistsConstraint::class),
            new \Lcobucci\JWT\Validation\Constraint\StrictValidAt($clock),
        );

        return $configuration;
    },

    \Psr\Http\Message\ResponseFactoryInterface::class => function () {
        return new \Slim\Psr7\Factory\ResponseFactory();
    },
]);
