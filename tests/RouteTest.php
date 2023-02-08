<?php

namespace Tests;

use DannyXCII\Router\Route;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\DataProvider\RouteDataProvider;

class RouteTest extends TestCase
{
    #[Test]
    #[DataProviderExternal(RouteDataProvider::class, 'invalidControllerArrayProvider')]
    public function itThrowsExceptionWhenPassedInvalidControllerArray(array $controller)
    {
        $this->expectException(\InvalidArgumentException::class);
        new Route('/', $controller);
    }

    #[Test]
    public function itIsDynamicWhenRouteIncludesBraces()
    {
        $route = new Route('/user/{id}', ['UserController', 'showUser']);
        $this->assertTrue($route->isDynamic());
    }

    #[Test]
    public function itIsNotDynamicWhenRouteDoesNotIncludeBraces()
    {
        $route = new Route('/users', ['UserController', 'index']);
        $this->assertFalse($route->isDynamic());
    }
}