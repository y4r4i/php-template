<?php

declare(strict_types=1);

use Medoo\Medoo;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, Medoo $db) use ($app) {
        error_log(json_encode($db->error));
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
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request) {
        throw new HttpNotFoundException($request);
    });
};
