<?php

namespace Tests\DataProvider;

use DannyXCII\Router\Exceptions\ControllerClassNotFoundException;
use DannyXCII\Router\Exceptions\InvalidRoutePathException;
use DannyXCII\Router\Route;
use Tests\Controller\TestController;

class RouterDataProvider
{
    /**
     * @return \Generator
     *
     * @throws InvalidRoutePathException|ControllerClassNotFoundException
     */
    public static function getRouteProvider(): \Generator
    {
        $cases = [
            'route from closure' => [
                $route = new Route('/posts/{post}', function () {
                    return 'Posts';
                }),
                ['GET' => [$route->getPath() => $route], 'POST' => []]
            ],
            'route from class/method array' => [
                $route = new Route('/', [TestController::class, 'index']),
                ['GET' => [$route->getPath() => $route], 'POST' => []]
            ],
            'dynamic route from closure' => [
                $route = new Route('/users/{id}', function() {
                    return 'Hello, world!';
                }),
                ['GET' => [$route->getPath() => $route], 'POST' => []]
            ],
            'dynamic route from class/method array' => [
                $route = new Route('/users/{id}/edit', [TestController::class, 'index']),
                ['GET' => [$route->getPath() => $route], 'POST' => []]
            ]
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     *
     * @throws InvalidRoutePathException|ControllerClassNotFoundException
     */
    public static function postRouteProvider(): \Generator
    {
        $cases = [
            'route from closure' => [
                $route = new Route('/posts/add', function () {
                    return 'Add post';
                }),
                ['GET' => [], 'POST' => [$route->getPath() => $route]]
            ],
            'route from class/method array' => [
                $route = new Route('/users/add', [TestController::class, 'index']),
                ['GET' => [], 'POST' => [$route->getPath() => $route]]
            ],
            'dynamic route from closure' => [
                $route = new Route('/posts/{id}/update', function () {
                    return 'Update post';
                }),
                ['GET' => [], 'POST' => [$route->getPath() => $route]]
            ],
            'dynamic route from class/method array' => [
                $route = new Route('/users/{id}/edit', [TestController::class, 'index']),
                ['GET' => [], 'POST' => [$route->getPath() => $route]]
            ]
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function validRequestMethodProvider(): \Generator
    {
        $cases = [
            'GET' => ['GET'],
            'POST' => ['POST'],
            'Get' => ['Get'],
            'post' => ['post']
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function invalidRequestMethodProvider(): \Generator
    {
        $cases = [
            'PUT' => ['PUT'],
            'PUSH' => ['PUSH'],
            'posting' => ['posting'],
            'got' => ['got']
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }
}