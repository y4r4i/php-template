<?php

declare(strict_types=1);

use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__.'/attributes/Route.php';
require_once __DIR__.'/attributes/RouteGroup.php';

return function (App $app) {
    $paths = glob(__DIR__.'/../routes/*.php');
    if (is_array($paths) === true) {
        foreach ($paths as $path) {
            include_once $path;
            $class           = pathinfo($path, PATHINFO_FILENAME);
            $reflectionClass = new ReflectionClass($class);
            foreach ($reflectionClass->getAttributes() as $classAttribute) {
                if ($classAttribute->getName() == 'RouteGroup') {
                    $groupAttribute = $classAttribute->newInstance();
                    $app->group(
                        $groupAttribute->pattern,
                        function (RouteCollectorProxy $group) use ($class, $reflectionClass) {
                            foreach ($reflectionClass->getMethods() as $method) {
                                if (!in_array($method->getName(), ['__construct', '__destruct'])) {
                                    foreach ($method->getAttributes() as $attribute) {
                                        if ($attribute->getName() == 'Route') {
                                            $methodAttribute = $attribute->newInstance();
                                            $pattern         = $methodAttribute->pattern;
                                            $pattern         = rtrim($pattern, '/');
                                            $group->map($methodAttribute->methods, $pattern, [$class, $method->getName()]);
                                        }
                                    }
                                }//end if
                            }//end foreach
                        }
                    );
                }
            }//end foreach
        }//end foreach
    }//end if

    $app->any(
        '/{routes:.+}',
        function ($request) {
            throw new HttpNotFoundException($request);
        }
    );

};
