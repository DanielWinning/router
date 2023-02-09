<?php

namespace DannyXCII\Router;

use DannyXCII\Router\Exceptions\InvalidRequestMethodException;

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

    /**
     * @param string $requestUri
     * @param string $requestMethod
     *
     * @return void
     *
     * @throws InvalidRequestMethodException
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        if (!$this->requestMethodIsValid($requestMethod)) {
            throw new InvalidRequestMethodException();
        }
    }

    /**
     * @param string $requestMethod
     *
     * @return bool
     */
    private function requestMethodIsValid(string $requestMethod): bool
    {
        return array_key_exists(strtoupper($requestMethod), $this->getRoutes());
    }
}