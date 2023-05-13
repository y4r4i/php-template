<?php

declare(strict_types=1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

return function (Request $request, RequestHandler $handler) {
    $uri = $request->getUri();
    $path = str_replace(getenv('BASE-PATH'), "", $uri->getPath());
    if ($path != '/' && str_ends_with($path, '/')) {
        $path = rtrim($path, '/');
        $uri = $uri->withPath($path);
        if ($request->getMethod() == 'GET') {
            $response = new Response();
            return $response
                ->withHeader('Location', (string)$uri)
                ->withStatus(301);
        } else {
            $request = $request->withUri($uri);
        }
    }
    return $handler->handle($request);
};
