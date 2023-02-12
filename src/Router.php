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
    public function resolve(string $requestUri, string $requestMethod): void
    {
        if (!$this->requestMethodIsValid($requestMethod)) {
            throw new InvalidRequestMethodException();
        }

        $uri = trim($requestUri, '/');
        $routeFound = false;

        if (array_key_exists($uri, $this->getRoutes()[strtoupper($requestMethod)])) {
            $this->getRoutes()[$requestMethod][$uri]->resolve();
            $routeFound = true;
        } else {
            foreach ($this->getRoutes()[strtoupper($requestMethod)] as $route) {
                /** @var Route $route **/
                if ($route->isDynamic() && $route->compare($uri)) {
                    $arguments = [];

                    foreach ($route->splitPath() as $index => $routeElement) {
                        if (str_contains($routeElement, '{')) {
                            $arguments[] = explode('/', $uri)[$index];
                        }
                    }

                    $route->resolve($arguments);
                    $routeFound = true;
                    break;
                }
            }
        }

        if (!$routeFound) {
            if (array_key_exists('404', $this->getRoutes()['GET'])) {
                $this->getRoutes()['GET']['404']->resolve();
            } else {
                echo 'Error 404: Page Not Found';
            }
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