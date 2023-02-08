<?php

namespace Tests\DataProvider;

use DannyXCII\Router\Route;

class RouteDataProvider
{
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
}