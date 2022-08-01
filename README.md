
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Validate against an object's constructor

[![Latest Version on Packagist](https://img.shields.io/packagist/v/morrislaptop/laravel-instantiate-rule.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/laravel-instantiate-rule)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/morrislaptop/laravel-instantiate-rule/run-tests?label=tests)](https://github.com/morrislaptop/laravel-instantiate-rule/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/morrislaptop/laravel-instantiate-rule/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/morrislaptop/laravel-instantiate-rule/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/morrislaptop/laravel-instantiate-rule.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/laravel-instantiate-rule)

Your validation rules often belong in your domain model. Use the `InstantiateRule` to bring those rules
into your Laravel validation. 

```php
class FormRequest 
{
    public function rules()
    {
        return [
            'email' => ['required', new InstantiateRule(EmailAddress::class)]
        ];
    }
}
```

## Installation

You can install the package via composer:

```bash
composer require morrislaptop/laravel-instantiate-rule
```

## Usage

As a simple rule

```php
class FormRequest 
{
    public function rules()
    {
        return [
            'email' => ['required', new InstantiateRule(EmailAddress::class)]
        ];
    }
}
```

For complex objects, it's assumed array keys match the constructor object or are in the order of the constructor.

```php
class Address
{
    public function __construct(
        private string $line1, 
        private string $postcode, 
        private string $country) {
    }
}

$this->jsonPost('/users', ['address' => [
    'line1' => '123 Fake St',
    'postcode' => '90210',
    'country' => 'Australia',
]]);
```

```php
class FormRequest 
{
    public function rules()
    {
        return [
            'address' => ['required', new InstantiateRule(Address::class)]
        ];
    }
}
```

Or you can specify a custom static contructor if you like...

```php
class FormRequest 
{
    public function rules()
    {
        return [
            'address' => ['required', new InstantiateRule(Address::class, 'createForValidation')]
        ];
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/morrislaptop/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Craig Morris](https://github.com/morrislaptop)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
