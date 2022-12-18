<?php

namespace Core;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

class Application
{
    private Router $router;

    private Request $request;

    public Response $response;

    public static Application $application;

    public static Container $container;

    public function __construct()
    {
        self::$application = $this;
        self::$container = new Container();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(): void
    {
        $response = $this->router->resolve();
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }
}
