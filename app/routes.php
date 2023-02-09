<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });
    $app->get('/csrf-token', function (Request $request, Response $response) use ($app) {
        $id = $app->getContainer()->get('id');
        setcookie('XSRF-TOKEN', $id, [
            'expires' => 0,
            'path' => '/',
            'samesite' => 'strict',
            'secure' => true,
            'httponly' => true,
        ]);
        return $response;
    });
};
