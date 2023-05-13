<?php

declare(strict_types=1);

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;

require __DIR__ . "/../app/components/UniqueId.php";

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, Medoo $db) use ($app) {
        return $response;
    });
    $app->get('/xsrf-cookie', function (Request $request, Response $response, UniqueId $uniqueId) use ($app) {
        setcookie('XSRF-TOKEN', $uniqueId(), [
            'expires' => 0,
            'path' => '/',
            'samesite' => 'strict',
            'secure' => true,
            'httponly' => true,
        ]);
        return $response;
    });
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request) {
        throw new HttpNotFoundException($request);
    });
};
