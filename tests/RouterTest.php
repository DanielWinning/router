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

    #[Test]
    public function itHasNoRoutesWhenFirstInstantiated()
    {
        $this->assertEquals(['GET' => [], 'POST' => []], $this->router->getRoutes());
    }

    #[Test]
    #[DataProviderExternal(RouterDataProvider::class, 'registersGetRouteData')]
    public function itRegistersGetRoute(Route $route, array $expected)
    {
        $this->router->get($route);
        $this->assertEquals($expected, $this->router->getRoutes());
    }

    #[Test]
    #[DataProviderExternal(RouterDataProvider::class, 'registersPostRouteData')]
    public function itRegistersPostRoute(Route $route, array $expected)
    {
        $this->router->post($route);
        $this->assertEquals($expected, $this->router->getRoutes());
    }
}