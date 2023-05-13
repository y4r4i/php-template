<?php

declare(strict_types=1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;

return function (Request $request, RequestHandler $handler) {
    $headers = getallheaders();
    if ($request->getMethod() != 'GET') {
        error_log(json_encode($headers));
        if (array_key_exists('x-xsrf-token', $headers) and array_key_exists("XSRF-TOKEN", $_COOKIE)) {
            if ($headers['x-xsrf-token'] == $_COOKIE["XSRF-TOKEN"]) {
                return $handler->handle($request);
            }
        }
        throw new HttpUnauthorizedException($request);
    }
    return $handler->handle($request);
};
