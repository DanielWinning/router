<?php

namespace Tests;

use DannyXCII\Router\Router;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->router = new Router();
    }

    #[Test]
    public function itRegistersGetRouteFromArray()
    {
        $this->router->get('/users', ['UserController', 'index']);

        $expected = [
            'GET' => [
                '/users' => [
                    'UserController',
                    'index'
                ],
            ],
            'POST' => []
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    #[Test]
    public function itRegistersGetRouteFromClosure()
    {
        $this->router->get('/hello', function () {
            echo 'Hello, world!';
        });

        $expected = [
            'GET' => [
                '/hello' => function () {
                    echo 'Hello, world!';
                },
            ],
            'POST' => []
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    #[Test]
    public function itThrowsInvalidArgumentExceptionWhenInvalidControllerArrayPassedToGetMethod()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->router->get('/invalid-array', ['UserController', 'index', 'getIndex']);
    }

    #[Test]
    public function itRegistersPostRouteFromArray()
    {
        $this->router->post('/users/{id}/update', ['UserController', 'updateUser']);

        $expected = [
            'GET' => [],
            'POST' => [
                '/users/{id}/update' => [
                    'UserController',
                    'updateUser'
                ]
            ]
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    #[Test]
    public function itRegistersPostRouteFromClosure()
    {
        $this->router->post('/post-closure', function () {
           return 'Hello, world!';
        });

        $expected = [
            'GET' => [],
            'POST' => [
                '/post-closure' => function () {
                    return 'Hello, world!';
                }
            ]
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    #[Test]
    public function itThrowsInvalidArgumentExceptionWhenInvalidControllerArrayPassedToPostMethod()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->router->post('/posts', ['PostController', 'index', 'showPosts']);
    }
}