![](/assets/banner.jpg)

# DataGrids 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/strucura/datagrids.svg?style=flat-square)](https://packagist.org/packages/strucura/datagrids)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/strucura/datagrids/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/strucura/datagrids/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/strucura/datagrids/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/strucura/datagrids/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/strucura/datagrids.svg?style=flat-square)](https://packagist.org/packages/strucura/datagrids)

A package for Laravel that provides a simple and front end agnostic way to create and manage data data grids.

## Installation

You can install the package via composer:

```bash
composer require strucura/datagrids
```

## Configuration

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="datagrids-config"
```

### Discovery of DataGrids

The discovery of grids in the application is configured in the `config/datagrids.php` file. This configuration allows 
the package to automatically discover grid classes within specified paths and under certain conditions.

Here is how the discovery process is set up:

1. **Paths**: The `paths` array specifies the directories where the package will look for grid classes. By default, it includes the `app` directory.
2. **Conditions**: The `conditions` array defines the criteria that a class must meet to be considered a grid. In this case, it uses the `DiscoverCondition` class to find classes that implement the `GridContract` interface.

```php
'discovery' => [
    'paths' => [
        app_path(''),
    ],
    'conditions' => [
        ConditionBuilder::create()
            ->classes()
            ->implementing(GridContract::class),
    ],
],
```

This setup ensures that any class within the specified paths that implements the `GridContract` interface will be automatically discovered and registered as a grid in the application.

### Value Transformers

Value transformers are used to perform data manipulations on the value of a filter before applying it to the query. 
They ensure that the filter values are in the correct format and type required by the database query.  Value 
transformers are registered in the `config/datagrids.php` file under the `value_transformers` key. Each transformer class must implement the `ValueTransformerContract` interface.

```php
'value_transformers' => [
    BooleanValueTransformer::class,
    TimezoneValueTransformer::class,
    FloatValueTransformer::class,
    IntegerValueTransformer::class,
    NullValueTransformer::class,
],
```

This configuration ensures that the specified transformers are applied to filter values in the order they are listed.

### Filters

Filters are used to apply specific conditions to the data being queried. They help in narrowing down the results 
based on various criteria.  Filters are registered in the `config/datagrids.php` file under the `filters` key. Each 
filter class must extend the `AbstractFilter` class and implement the `FilterContract` interface.

```php
'filters' => [
    StringFilter::class,
    NumericFilter::class,
    DateFilter::class,
    EqualityFilter::class,
    InFilter::class,
    NullFilter::class,
],
```

This configuration ensures that the specified filters are available for use in the application. Each filter class defines the conditions it can handle and the logic to apply those conditions to the query.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andrew Leach](https://github.com/7387639+andyleach)
- [All Contributors](../../contributors)

## License

ihe MIT License (MIT). Please see [License File](LICENSE.md) for more information.
