<?php

namespace DannyXCII\Router;

use DannyXCII\Router\Exceptions\InvalidRoutePathException;

class Route
{
    private string $path;
    private array|\Closure $controller;

    /**
     * @throws InvalidRoutePathException
     */
    public function __construct(string $path, array|\Closure $controller)
    {
        $this->setPath($path);
        $this->setController($controller);
    }

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws InvalidRoutePathException
     */
    private function setPath(string $path): void
    {
        if (!$this->pathIsValid($path)) {
            throw new InvalidRoutePathException();
        }

        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param String[]|\Closure $controller
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    private function setController(array|\Closure $controller): void
    {
        if (!$this->controllerIsValid($controller)) {
            throw new \InvalidArgumentException();
        }

        $this->controller = $controller;
    }

    /**
     * @return array|\Closure
     */
    public function getController(): array|\Closure
    {
        return $this->controller;
    }

    /**
     * @return bool
     */
    public function isDynamic(): bool
    {
        return str_contains($this->getPath(), '{') && str_contains($this->getPath(), '}');
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function pathIsValid(string $path): bool
    {
        if (str_contains($path, '{') || str_contains($path, '}')) {
            if (substr_count($path, '{') !== substr_count($path, '}')) {
                return false;
            }

            foreach (explode('/', $path) as $routePart) {
                if (str_starts_with($routePart, '{') && !str_ends_with($routePart, '}')) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param array|\Closure $controller
     *
     * @return bool
     */
    private function controllerIsValid(array|\Closure $controller): bool
    {
        if (is_array($controller) && count($controller) !== 2) {
            return false;
        }

        foreach ($controller as $item) {
            if (!is_string($item)) {
                return false;
            }
        }

        return true;
    }
}