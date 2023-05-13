<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) use ($app) {
        return $response;
    });
    $app->options('/{routes:.+}', function (Request $request, Response $response) {
        return $response;
    });
    $app->get('/xsrf-cookie', function (Request $request, Response $response) use ($app) {
        $id = require __DIR__ . '/util/id.php';
        setcookie('XSRF-TOKEN', $id(), [
            'expires' => 0,
            'path' => '/',
            'samesite' => 'strict',
            'secure' => true,
            'httponly' => true,
        ]);
        return $response;
    });
    $app->options('/{routes:.+}', function (Request $request, Response $response) {
        return $response;
    });
};
