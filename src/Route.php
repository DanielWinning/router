<?php

namespace DannyXCII\Router;

class Route
{
    private string $path;
    private array|\Closure $controller;

    public function __construct(string $path, array|\Closure $controller)
    {
        $this->setPath($path);
        $this->setController($controller);
    }

    /**
     * @param string $path
     *
     * @return void
     */
    private function setPath(string $path): void
    {
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
     */
    private function setController(array|\Closure $controller): void
    {
        if (is_array($controller) && count($controller) !== 2) {
            throw new \InvalidArgumentException();
        }

        foreach ($controller as $item) {
            if (!is_string($item)) {
                throw new \InvalidArgumentException();
            }
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
}