<?php

namespace Sourceboat\LaravelClockifyApi\Tests;

use Config;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Config::set('clockify.api_key', '');
        Config::set('clockify.workspace_id', '');
    }
}