<?php

namespace tests\Tests;

use DannyXCII\Router\Exceptions\ControllerClassNotFoundException;
use DannyXCII\Router\Exceptions\InvalidRequestMethodException;
use DannyXCII\Router\Exceptions\InvalidRoutePathException;
use DannyXCII\Router\Route;
use DannyXCII\Router\Router;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use Tests\BaseTest;
use Tests\Controller\TestController;
use Tests\DataProvider\RouteDataProvider;
use Tests\DataProvider\RouterDataProvider;

class RouterTest extends BaseTest
{
    private Router $router;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->router = new Router();
    }

    /**
     * @return void
     */
    #[Test]
    public function itHasNoRoutesWhenFirstInstantiated(): void
    {
        $this->assertEquals(['GET' => [], 'POST' => []], $this->router->getRoutes());
    }

    /**
     * @param Route $route
     * @param array $expected
     *
     * @return void
     */
    #[Test]
    #[DataProviderExternal(RouterDataProvider::class, 'getRouteProvider')]
    public function itRegistersGetRoute(Route $route, array $expected): void
    {
        $this->router->get($route);
        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /**
     * @param Route $route
     * @param array $expected
     *
     * @return void
     */
    #[Test]
    #[DataProviderExternal(RouterDataProvider::class, 'postRouteProvider')]
    public function itRegistersPostRoute(Route $route, array $expected): void
    {
        $this->router->post($route);
        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /**
     * @param string $requestMethod
     *
     * @return void
     *
     * @throws InvalidRequestMethodException
     */
    #[Test]
    #[DataProviderExternal(RouterDataProvider::class, 'validRequestMethodProvider')]
    public function itResolvesValidRequestMethod(string $requestMethod): void
    {
        $this->router->resolve('/', $requestMethod);
        $this->expectNotToPerformAssertions();
    }

    /**
     * @param string $requestMethod
     *
     * @return void
     *
     * @throws InvalidRequestMethodException
     */
    #[Test]
    #[DataProviderExternal(RouterDataProvider::class, 'invalidRequestMethodProvider')]
    public function itThrowsExceptionResolvingInvalidRequestMethod(string $requestMethod): void
    {
        $this->expectException(InvalidRequestMethodException::class);
        $this->router->resolve('/', $requestMethod);
    }

    /**
     * @param string $path
     *
     * @return void
     *
     * @throws ControllerClassNotFoundException|InvalidRequestMethodException|InvalidRoutePathException
     */
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'simplePathProvider')]
    public function itResolvesSimpleRoute(string $path): void
    {
        $this->router->get(new Route($path, [TestController::class, 'index']));
        $this->router->resolve($path, 'GET');
        $this->expectNotToPerformAssertions();
    }

    /**
     * @return void
     *
     * @throws ControllerClassNotFoundException|InvalidRequestMethodException|InvalidRoutePathException
     */
    #[Test]
    public function itResolvesRouteWithArguments(): void
    {
        $this->router->get(new Route('/users/{id}', function (string $userId) {
            echo 'User: ' . $userId;
        }));
        $this->router->resolve('/users/12', 'GET');
        $this->expectNotToPerformAssertions();
    }
}