<?php

namespace Core;

use JetBrains\PhpStorm\Pure;

class Request
{
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    #[Pure] public static function getParam(string $name)
    {
        return static::getParams()[$name] ?? null;
    }

    public static function getParams(): array
    {
        return array_merge($_GET, $_POST);
    }
}
