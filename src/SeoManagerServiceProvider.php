<?php

declare(strict_types=1);

namespace MichaelRubel\SeoManager;

use MichaelRubel\EnhancedContainer\LecServiceProvider;
use MichaelRubel\SeoManager\Composers\SeoComposer;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SeoManagerServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param Package $package
     *
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-seo-manager')
            ->hasConfigFile()
            ->hasViewComposer('*', SeoComposer::class)
            ->hasMigration('create_seo_tags_table');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function packageRegistered(): void
    {
        $this->app->register(LecServiceProvider::class);

        $this->app->scoped(SeoComposer::class);
    }
}
