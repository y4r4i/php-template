<?php

declare(strict_types=1);

class BasePath
{


    public function __invoke(): string
    {
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $uri       = (string) parse_url('http://a'.($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
        if (stripos($uri, $_SERVER['SCRIPT_NAME']) === 0) {
            return $_SERVER['SCRIPT_NAME'];
        }

        if ($scriptDir !== '/' && stripos($uri, $scriptDir) === 0) {
            return $scriptDir;
        }

        return '';

    }//end __invoke()


}//end class
