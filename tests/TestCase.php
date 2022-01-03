<?php

namespace MichaelRubel\SeoManager\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use MichaelRubel\SeoManager\SeoManagerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase, InteractsWithViews;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SeoManagerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('testing');
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'seo-manager-migrations',
        ])->run();

        $this->artisan('migrate')->run();

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback')->run();
        });
    }

    /**
     * @param string $url
     *
     * @return void
     */
    protected function mockRequest(string $url): void
    {
        $mockery = $this->mock(Request::class)
            ->makePartial()
            ->shouldReceive('path')
            ->once()
            ->andReturn($url);

        app()->instance('request', $mockery->getMock());
    }
}
