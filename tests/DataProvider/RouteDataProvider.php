<?php

namespace Tests\DataProvider;

class RouteDataProvider
{
    /**
     * @return \Generator
     */
    public static function invalidControllerArrayProvider(): \Generator
    {
        $cases = [
            'empty array' => [[]],
            'array of integers' => [[1, 2]],
            'array of DateTime objects' => [[new \DateTime(), new \DateTime()]]
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function invalidRoutePathProvider(): \Generator
    {
        $cases = [
            '/hello{/world' => ['/hello{/world'],
            '/users/{id/1}' => ['/users/{id/1}'],
            '/users/?!/' => ['/users/?!/'],
            '//users//' => ['//users//']
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function dynamicPathProvider(): \Generator
    {
        $cases = [
            '/users/{id}' => ['/users/{id}'],
            '/users/{id}/edit' => ['/users/{id}/edit'],
            '/posts/{category}/{post}' => ['/posts/{category}/{post}']
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function simplePathProvider(): \Generator
    {
        $cases = [
            '/' => ['/'],
            '/users' => ['/users'],
            '/posts/all' => ['/posts/all'],
            '/contact-us' => ['/contact-us/']
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function pathToSplitProvider(): \Generator
    {
        $cases = [
            '/' => ['/', ['']],
            '/api/users/all' => ['/api/users/all', ['api', 'users', 'all']],
            '/users/{id}/edit' => ['/users/{id}/edit', ['users', '{id}', 'edit']]
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function routeLengthProvider(): \Generator
    {
        $cases = [
            '/' => ['/', 1],
            '/api/users/all' => ['/api/users/all', 3],
            'users/{id}/edit' => ['users/{id}/edit', 3],
            '/admin/posts/{id}/contact-info/update' => ['/admin/posts/{id}/contact-info/update', 5]
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function dynamicRouteMatchProvider(): \Generator
    {
        $cases = [
            'users/{id} matches' => [
                ['/users/{id}', '/users/1'],
                true
            ],
            'api/v1/users/{method}/{user} matches' => [
                ['/api/v1/users/{method}/{user}', 'api/v1/users/view/1'],
                true
            ]
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function queryStringPathProvider(): \Generator
    {
        $cases = [
            '/users/all?role=user&confirmed=1' => [
                '/users/all?role=user&confirmed=1',
                '/users/all'
            ]
        ];

        foreach ($cases as $name => $case) {
            yield $name => $case;
        }
    }
}