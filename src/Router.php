<?php

namespace DannyXCII\Router;

use DannyXCII\Router\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes;

    /**
     * @param string $route
     * @param callable $action
     *
     * @return $this
     */
    public function register(string $route, callable $action): self
    {
        $this->routes[$route] = $action;

        return $this;
    }

    /**
     * @param string $requestUri
     *
     * @return mixed
     *
     * @throws RouteNotFoundException
     */
    public function resolve(string $requestUri): mixed
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        return call_user_func($action);
    }
}