![Laravel SEO Manager](https://user-images.githubusercontent.com/37669560/147988859-5d33959e-f43d-4ae6-816a-59c26c17a0ad.png)

# Laravel SEO Manager
[![Latest Version on Packagist](https://img.shields.io/packagist/v/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-seo-manager)
[![Total Downloads](https://img.shields.io/packagist/dt/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=packagist)](https://packagist.org/packages/michael-rubel/laravel-seo-manager)
[![Code Quality](https://img.shields.io/scrutinizer/quality/g/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-seo-manager/?branch=main)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/michael-rubel/laravel-seo-manager.svg?style=flat-square&logo=scrutinizer)](https://scrutinizer-ci.com/g/michael-rubel/laravel-seo-manager/?branch=main)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/michael-rubel/laravel-seo-manager/run-tests/main?style=flat-square&label=tests&logo=github)](https://github.com/michael-rubel/laravel-seo-manager/actions)
[![PHPStan](https://img.shields.io/github/workflow/status/michael-rubel/laravel-seo-manager/phpstan/main?style=flat-square&label=larastan&logo=laravel)](https://github.com/michael-rubel/laravel-seo-manager/actions)

This package provides simple functionality to manage SEO tags in your Laravel application.

You can put the URL available within your app, and the JSON of tags you want to get in the view under the specified path relative to the domain, for example, `/foo/bar`. You can use `*` notation to cover the paths as a wildcard. You will get the manager variable with tags for each view as a `Collection` instance by default. The model to use by the package and variable name is customizable in the config file.

The package requires PHP `^8.x` and Laravel `^8.67`.

[![PHP Version](https://img.shields.io/badge/php-^8.x-777BB4?style=flat-square&logo=php)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/laravel-^8.67-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Laravel Octane Compatible](https://img.shields.io/badge/octane-compatible-success?style=flat-square&logo=laravel)](https://github.com/laravel/octane)

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

## Roadmap
- Add Livewire scaffolding.

## Contributing
If you see the way we can improve the package, you're free to open an issue or pull request.

## Testing
```bash
composer test
```
