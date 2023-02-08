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
            [[]],
            [[1, 2]],
            [[new \DateTime(), new \DateTime()]]
        ];

        foreach ($cases as $case) {
            yield $case;
        }
    }

    /**
     * @return \Generator
     */
    public static function invalidRoutePathProvider(): \Generator
    {
        $cases = [
            ['/hello{/world'],
            ['/users/{id/1}'],
            ['/users/?!/'],
            ['//users//']
        ];

        foreach ($cases as $case) {
            yield $case;
        }
    }
}