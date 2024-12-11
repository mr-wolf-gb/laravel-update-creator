# Laravel Update Creator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mr-wolf-gb/laravel-update-creator.svg?style=flat-square)](https://packagist.org/packages/mr-wolf-gb/laravel-update-creator)
[![Total Downloads](https://img.shields.io/packagist/dt/mr-wolf-gb/laravel-update-creator.svg?style=flat-square)](https://packagist.org/packages/mr-wolf-gb/laravel-update-creator)

Laravel Update Creator is a Laravel package designed to streamline the process of creating update ZIP files for your Laravel projects. This tool identifies all files modified since
a specified date, excludes unwanted directories and files, and generates a compressed ZIP file for distribution or deployment.

## Features

- **Customizable Date Range** : Specify a start date to include files modified after that point.
- **Version Control** : Add version numbers to the generated updates for better tracking.
- **Exclude Directories** : Automatically excludes common directories like vendor, node_modules, and others.
- **Temporary Cleanup** : Ensures the temporary directories used during the process are cleaned up after ZIP creation.
- **Simple Configuration** : Easily configure excluded directories and default behaviors via a configuration file.

## Installation

1. Add the package to your Laravel project via Composer:

```bash
composer require mr-wolf-gb/laravel-update-creator
```

2. Publish the configuration file (Optional):

```bash
php artisan vendor:publish --tag=config --provider="MrWolfGb\LaravelUpdateCreator\LaravelUpdateCreatorServiceProvider"
```

## Usage

```php
// specify the date since the modified files to copy them into the update pack
php artisan update:create --date="2024-01-01" --version="1.2.0"

//by default after creating the update zip file the copied temporary files will be deleted, to disable the deletion of temporary files use:
php artisan update:create --date="2024-01-01" --version="1.2.0" --clean="true"
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email gaiththewolf@gmail.com instead of using the issue tracker.

## Credits

- [Mr.WOLF](https://github.com/mr-wolf-gb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
