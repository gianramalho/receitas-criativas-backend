<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function PrepareHeader()
    {
        return [
            'Accept' => 'application/json',
            'X-Device-Name' => 'Test',
            'api-version' => '1.0',
        ];
    }
}
