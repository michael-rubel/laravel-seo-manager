<?php

namespace MichaelRubel\SeoManager\Tests\Stubs;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'test-seo-manager');
    }
}
