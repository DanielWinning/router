<?php

namespace Tests\Test;

use DannyXCII\Router\Exceptions\ControllerClassNotFoundException;
use DannyXCII\Router\Exceptions\InvalidRoutePathException;
use DannyXCII\Router\Route;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use Tests\BaseTest;
use Tests\Controller\TestController;
use Tests\DataProvider\RouteDataProvider;

class RouteTest extends BaseTest
{
    /**
     * @param array $controller
     *
     * @return void
     *
     * @throws InvalidRoutePathException|ControllerClassNotFoundException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'invalidControllerArrayProvider')]
    public function itThrowsInvalidArgumentException(array $controller): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Route('/', $controller);
    }

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws ControllerClassNotFoundException|InvalidRoutePathException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'invalidRoutePathProvider')]
    public function itThrowsInvalidRoutePathException(string $path): void
    {
        $this->expectException(InvalidRoutePathException::class);
        new Route($path, [TestController::class, 'index']);
    }

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws InvalidRoutePathException|ControllerClassNotFoundException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'dynamicPathProvider')]
    public function itIsDynamic(string $path): void
    {
        $route = new Route($path, [TestController::class, 'index']);
        $this->assertTrue($route->isDynamic());
    }

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws InvalidRoutePathException|ControllerClassNotFoundException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'simplePathProvider')]
    public function itIsNotDynamic(string $path): void
    {
        $route = new Route($path, [TestController::class, 'index']);
        $this->assertFalse($route->isDynamic());
    }

    /**
     * @return void
     *
     * @throws InvalidRoutePathException
     */
    #[Test]
    public function itThrowsControllerClassNotFoundException(): void
    {
        $this->expectException(ControllerClassNotFoundException::class);
        new Route('/', ['IndexController', 'index']);
    }

    /**
     * @param string $path
     * @param array $expected
     *
     * @return void
     *
     * @throws ControllerClassNotFoundException|InvalidRoutePathException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'pathToSplitProvider')]
    public function itCanSplitPathIntoParts(string $path, array $expected): void
    {
        $route = new Route($path, [TestController::class, 'index']);
        $this->assertEquals($expected, $route->splitPath());
    }

    /**
     * @param string $path
     * @param int $expected
     *
     * @return void
     *
     * @throws ControllerClassNotFoundException|InvalidRoutePathException|\ReflectionException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'routeLengthProvider')]
    public function itCountsPathLength(string $path, int $expected): void
    {
        $route = new Route($path, [TestController::class, 'index']);
        $method = $this->getPrivateMethod($route, 'getLength');
        $this->assertEquals($expected, $method->invoke($route));
    }

    /**
     * @param array $path
     * @param bool $expected
     *
     * @return void
     *
     * @throws ControllerClassNotFoundException|InvalidRoutePathException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'dynamicRouteMatchProvider')]
    public function itMatchesDynamicRoutes(array $path, bool $expected): void
    {
        $route = new Route($path[0], [TestController::class, 'index']);
        $this->assertEquals($expected, $route->compare($path[1]), $route->getPath() . ' ' . $path[1]);
    }
}