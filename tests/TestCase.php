<?php

namespace Sourceboat\LaravelClockifyApi\Tests;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{

    public function setUp(): void
    {
        parent::setUp();

        Config::set('clockify.api_key', '');
        Config::set('clockify.workspace_id', '');
    }

}
