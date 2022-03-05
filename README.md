![Laravel SEO Manager](https://user-images.githubusercontent.com/37669560/148681448-a9e56602-5e40-47e0-8fa1-a9477004590f.png)

# Laravel SEO Manager
[![Latest Version on Packagist](https://img.shields.io/packagist/v/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-seo-manager)
[![Total Downloads](https://img.shields.io/packagist/dt/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-seo-manager)
[![Code Quality](https://img.shields.io/scrutinizer/quality/g/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-seo-manager/?branch=main)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-seo-manager/?branch=main)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/michael-rubel/laravel-seo-manager/run-tests/main?style=flat-square&label=tests&logo=github)](https://github.com/michael-rubel/laravel-seo-manager/actions)
[![PHPStan](https://img.shields.io/github/workflow/status/michael-rubel/laravel-seo-manager/phpstan/main?style=flat-square&label=larastan&logo=laravel)](https://github.com/michael-rubel/laravel-seo-manager/actions)

This package provides simple functionality to manage SEO tags based on URL path within your Laravel application.

You can put the URL path available within your app with the JSON of tags you want to get in the view under the specified path. The wildcard `*` notation is available as well. You will get the manager variable with tags for each view as a `Collection` instance by default. The model to use by the package and variable name is customizable in the config file.

The package requires PHP `^8.x` and Laravel `^8.71` or `^9.0`.

## #StandWithUkraine
[![SWUbanner](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/banner2-direct.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

## Installation
Install the package using composer:
```bash
composer require michael-rubel/laravel-seo-manager
```

Publish the migration:
```bash
php artisan vendor:publish --tag="seo-manager-migrations"
```

Publish the config file:
```bash
php artisan vendor:publish --tag="seo-manager-config"
```

## Usage
After publishing the config and running migrations, you can apply URLs in the `seo_tags` table using following patterns:
- `/test-url/*`
- `/test-url/my-target`
- `/test-url/any-target/*`

Wildcard `*` has a lower priority than explicit define.

- Note: If you're going to override the model to use a different database structure, make sure your model implements [SeoTagContract](https://github.com/michael-rubel/laravel-seo-manager/blob/main/src/Contracts/SeoTagContract.php). The package uses two simple methods to get the database columns.

## Roadmap
- Add Livewire scaffolding.

## Contributing
If you see the way we can improve the package, you're free to open an issue or pull request.

## Testing
```bash
composer test
```
