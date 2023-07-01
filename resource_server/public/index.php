<?php

declare(strict_types=1);

use App\Handler\ProfileHandler;
use App\Middleware\IsSignedInMiddleware;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

require __DIR__ . '/../config/dependencies.php';
require __DIR__ . '/../config/settings.php';

AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->get('/profile', [ProfileHandler::class, 'profile'])->add(IsSignedInMiddleware::class);

$app->run();
