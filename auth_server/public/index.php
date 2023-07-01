<?php

declare(strict_types=1);

use App\Handler\AuthHandler;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

require __DIR__ . '/../config/dependencies.php';
require __DIR__ . '/../config/settings.php';

AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->post('/sign_in', [AuthHandler::class, 'signIn']);

$app->run();
