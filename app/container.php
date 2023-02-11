<?php

declare(strict_types=1);

use DI\Container;

return function (): Container {
    $container = new Container();
    $id = require __DIR__ . '/util/id.php';
    $container->set('id', $id);
    return $container;
};