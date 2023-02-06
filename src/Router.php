<?php

namespace DannyXCII\Router;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * @param string $route
     * @param array|\Closure $controller
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function get(string $route, array|\Closure $controller): void
    {
        if (is_array($controller) && count($controller) !== 2) {
            throw new \InvalidArgumentException(
                'Array should contain two values: controller name and method name'
            );
        }

        $this->routes['GET'][$route] = $controller;
    }

    /**
     * @param string $route
     * @param array|\Closure $controller
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function post(string $route, array|\Closure $controller): void
    {
        if (is_array($controller) && count($controller) !== 2) {
            throw new \InvalidArgumentException(
                'Array should contain two values: controller name and method name'
            );
        }

        $this->routes['POST'][$route] = $controller;
    }

    /**
     * @return array|array[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}