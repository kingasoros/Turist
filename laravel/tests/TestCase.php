<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

}
