<?php

declare(strict_types=1);

class Config
{
    private mixed $config;

    public function __construct(string $path = __DIR__ . "/../../config.json")
    {
        $json = file_get_contents($path);
        $this->config = json_decode($json, true);
    }

    public function __invoke()
    {
        return $this->config;
    }
}
