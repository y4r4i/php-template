<?php

declare(strict_types=1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpBadRequestException;

return function (Request $request, RequestHandler $handler) {
    $headers = getallheaders();
    if ($request->getMethod() != 'GET') {
        if (!array_key_exists('X-Requested-With', $headers)) {
            if ($headers['X-Requested-With'] != 'XMLHttpRequest') {
                throw new HttpBadRequestException($request);
            }
        }
    }
    return $handler->handle($request);
};