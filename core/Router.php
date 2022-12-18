<?php

namespace Core;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;

class Router
{
    protected static array $routes = [];

    public function __construct(protected Request $request, protected Response $response)
    {
        include_once __DIR__ . '/../routes/api.php';
    }

    public static function get($path, $callback): void
    {
        self::$routes['get'][$path] = $callback;
    }

    public static function post($path, $callback): void
    {
        self::$routes['post'][$path] = $callback;
    }

    public static function put($path, $callback): void
    {
        self::$routes['put'][$path] = $callback;
    }

    public static function patch($path, $callback): void
    {
        self::$routes['patch'][$path] = $callback;
    }

    public static function delete($path, $callback): void
    {
        self::$routes['delete'][$path] = $callback;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    public function resolve(): Response
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();
        if (!isset(self::$routes[$method][$path]))
            return $this->response->setStatusCode(404);

        [$nameController, $nameAction] = self::$routes[$method][$path];
        $controllerObj = new $nameController;
        return $controllerObj->$nameAction();
    }
}
