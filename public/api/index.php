<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\App;

session_start();

require __DIR__ . '/../../vendor/autoload.php';
$dependencies = require __DIR__ . '/../../app/dependencies.php';
$basePath = require __DIR__ . '/../../app/util/basePath.php';
$middleware = require __DIR__ . '/../../app/middleware.php';
$routes = require __DIR__ . '/../../app/routes.php';
putenv('BASE-PATH=' . $basePath());
$builder = new ContainerBuilder();
$dependencies($builder);
$container = $builder->build();
$app = $container->get(App::class);
$app->setBasePath(getenv('BASE-PATH'));
$middleware($app);
$routes($app);
$app->run();
