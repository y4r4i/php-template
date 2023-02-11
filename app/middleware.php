<?php

declare(strict_types=1);

use Slim\App;
use Slim\Middleware\ContentLengthMiddleware;
use Slim\Middleware\MethodOverrideMiddleware;
use Slim\Middleware\OutputBufferingMiddleware;
use Slim\Psr7\Factory\StreamFactory;

return function (App $app) {
    foreach (glob(__DIR__ . '/middleware/*.php') as $path) {
        $app->add(require $path);
    }
    $app->addBodyParsingMiddleware();
    $outputBufferingMiddleware = new OutputBufferingMiddleware(new StreamFactory(), OutputBufferingMiddleware::PREPEND);
    $app->add($outputBufferingMiddleware);
    $methodOverrideMiddleware = new MethodOverrideMiddleware();
    $app->add($methodOverrideMiddleware);
    $logger = require __DIR__ . '/util/logger.php';
    $app->addErrorMiddleware(true, true, true, $logger());
    $contentLengthMiddleware = new ContentLengthMiddleware();
    $app->add($contentLengthMiddleware);
};