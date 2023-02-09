<?php

namespace Tests;

use DannyXCII\Router\Exceptions\InvalidRoutePathException;
use DannyXCII\Router\Route;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\DataProvider\RouteDataProvider;

class RouteTest extends TestCase
{
    /**
     * @param array $controller
     *
     * @return void
     *
     * @throws InvalidRoutePathException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'invalidControllerArrayProvider')]
    public function itThrowsInvalidArgumentException(array $controller): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Route('/', $controller);
    }

    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'invalidRoutePathProvider')]
    public function itThrowsInvalidRoutePathException(string $path)
    {
        $this->expectException(InvalidRoutePathException::class);
        new Route($path, ['IndexController', 'index']);
    }

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws InvalidRoutePathException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'dynamicPathProvider')]
    public function itIsDynamic(string $path): void
    {
        $route = new Route($path, ['UserController', 'showUser']);
        $this->assertTrue($route->isDynamic());
    }

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws InvalidRoutePathException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'notDynamicPathProvider')]
    public function itIsNotDynamic(string $path): void
    {
        $route = new Route($path, ['UserController', 'index']);
        $this->assertFalse($route->isDynamic());
    }
}