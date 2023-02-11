<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;

require __DIR__ . '/../../vendor/autoload.php';
$container = require __DIR__ . '/../../app/container.php';
$basePath = require __DIR__ . '/../../app/util/basePath.php';
$middleware = require __DIR__ . '/../../app/middleware.php';
$routes = require __DIR__ . '/../../app/routes.php';
putenv('BASE-PATH=' . $basePath());
$app = Bridge::create($container());
$app->setBasePath(getenv('BASE-PATH'));
$middleware($app);
$routes($app);
$app->run();