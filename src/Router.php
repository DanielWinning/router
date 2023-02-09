<?php

namespace DannyXCII\Router;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * @param Route $route
     *
     * @return void
     */
    public function get(Route $route): void
    {
        $this->routes['GET'][$route->getPath()] = $route;
    }

    /**
     * @param Route $route
     *
     * @return void
     */
    public function post(Route $route): void
    {
        $this->routes['POST'][$route->getPath()] = $route;
    }

    /**
     * @return array|array[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {

    }
}