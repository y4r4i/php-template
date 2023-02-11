<?php

declare(strict_types=1);

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return function (): Logger {
    $logger = new Logger('app');
    $streamHandler = new StreamHandler(__DIR__ . '/../../logs', 100);
    $logger->pushHandler($streamHandler);
    return $logger;
};