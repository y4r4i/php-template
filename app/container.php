<?php

use DI\Container;

return function () {
    $container = new Container();
    $id = require __DIR__ . '/util/id.php';
    $container->set('id', $id());
    $basePath = require __DIR__ . '/util/basePath.php';
    $container->set('basePath', $basePath());
    return $container;
};