<?php

namespace Tests\Controller;

class TestController
{
    public function index(): string
    {
        return 'Index page';
    }

    public function about(): string
    {
        return 'About page';
    }
}