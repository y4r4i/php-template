<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Slim\App;

session_start();

require __DIR__ . '/../../vendor/autoload.php';
$dependencies = require __DIR__ . '/../../app/dependencies.php';
$middleware = require __DIR__ . '/../../app/middlewares.php';
$routes = require __DIR__ . '/../../app/routes.php';
$builder = new ContainerBuilder();
$dependencies($builder);

require_once __DIR__ . "/../../app/components/BasePath.php";

try {
    $container = $builder->build();
    $app = $container->get(App::class);
    $basePath = $container->get(BasePath::class);
    $app->setBasePath($basePath());
    $middleware($app);
    $routes($app);
    $app->run();
} catch (NotFoundException|DependencyException|Exception $e) {
    error_log($e->getMessage());
}
