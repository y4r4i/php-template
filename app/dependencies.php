<?php

declare(strict_types=1);

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;
use Medoo\Medoo;
use Psr\Container\ContainerInterface;
use Slim\App;

require __DIR__ . "/../components/Config.php";

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        App::class => function (ContainerInterface $container) {
            return Bridge::create($container);
        },
        Config::class => function () {
            return new Config();
        },
        Medoo::class => function (Config $config) {
            return new Medoo($config()["database"]);
        }
    ]);
};