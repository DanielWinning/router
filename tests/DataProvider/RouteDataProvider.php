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
    public static function notDynamicPathProvider(): \Generator
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
}