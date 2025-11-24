<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // setup
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }
}
