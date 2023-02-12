<?php

namespace DannyXCII\Router;

use DannyXCII\Router\Exceptions\ControllerClassNotFoundException;
use DannyXCII\Router\Exceptions\InvalidRoutePathException;

class Route
{
    private string $path;
    private array|\Closure $controller;

    /**
     * @throws InvalidRoutePathException|ControllerClassNotFoundException
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

        $this->path = trim($path, '/');
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
     * @throws \InvalidArgumentException|ControllerClassNotFoundException
     */
    private function setController(array|\Closure $controller): void
    {
        if (!$this->controllerIsValid($controller)) {
            throw new \InvalidArgumentException();
        }

        if (is_array($controller) && !class_exists($controller[0])) {
            throw new ControllerClassNotFoundException();
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
        if (preg_match('/[?!\[\]@\'"£$%^&*()+=`#~]/', $path) || str_contains($path, '\\') || str_contains($path, '//')) {
            return false;
        }

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

    /**
     * @return void
     */
    public function resolve(): void
    {
        if (is_array($this->getController())) {
            $class = new ($this->getController()[0]);
            $class->{$this->getController()[1]}();
        } else {
            ($this->getController())();
        }
    }

    /**
     * @return array
     */
    public function splitPath(): array
    {
        return explode('/', $this->getPath());
    }

    /**
     * @return int
     */
    private function getLength(): int
    {
        return count($this->splitPath());
    }

    /**
     * @param string $requestUri
     *
     * @return bool
     */
    public function compare(string $requestUri): bool
    {
        $explodedRequestUri = explode('/', trim($requestUri, '/'));

        if (count($explodedRequestUri) !== $this->getLength()) {
            return false;
        }

        foreach ($this->splitPath() as $index => $pathElement) {
            if (!str_contains($pathElement, '{') && ($pathElement !== $explodedRequestUri[$index])) {
                return false;
            }
        }

        return true;
    }
}