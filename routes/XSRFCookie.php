<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require_once __DIR__.'/../app/components/UniqueId.php';
#[RouteGroup('/xsrf-cookie')]
class XSRFCookie
{

    private UniqueId $uniqueId;


    public function __construct(ContainerInterface $container)
    {
        $this->uniqueId = $container->get(UniqueId::class);

    }//end __construct()


    #[Route('/', ['get'])]
    public function __invoke(Request $request, Response $response): Response
    {
        setcookie(
            'XSRF-TOKEN',
            $this->uniqueId->__invoke(),
            [
                'expires'  => 0,
                'path'     => '/',
                'samesite' => 'strict',
                'secure'   => true,
                'httponly' => true,
            ]
        );
        return $response;

    }//end __invoke()


}//end class
