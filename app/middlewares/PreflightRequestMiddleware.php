<?php

declare(strict_types=1);

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpBadRequestException;

class PreflightRequestMiddleware
{


    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $headers = getallheaders();
        if ($request->getMethod() != 'GET') {
            if (!array_key_exists('x-requested-with', $headers)) {
                if ($headers['x-requested-with'] != 'XMLHttpRequest') {
                    throw new HttpBadRequestException($request);
                }
            }
        }

        return $handler->handle($request);

    }//end __invoke()


}//end class
