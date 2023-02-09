<?php

namespace Tests;

use DannyXCII\Router\Route;
use DannyXCII\Router\Router;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\DataProvider\RouterDataProvider;

class RouterTest extends TestCase
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
}