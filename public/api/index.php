<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;

require __DIR__ . '/../../vendor/autoload.php';
$container = require __DIR__ . '/../../app/container.php';
$app = Bridge::create($container());
$app->setBasePath($app->getContainer()->get('basePath'));
$middleware = require __DIR__ . '/../../app/middleware.php';
$middleware($app);
$routes = require __DIR__ . '/../../app/routes.php';
$routes($app);
$app->run();