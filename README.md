# Nova Tool for Staff to Make Bookings

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tipoff/staff-bookings.svg?style=flat-square)](https://packagist.org/packages/tipoff/staff-bookings)
![Tests](https://github.com/tipoff/staff-bookings/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tipoff/staff-bookings.svg?style=flat-square)](https://packagist.org/packages/tipoff/staff-bookings)

Booking form for Nova.

## Installation

You can install the package via composer:

```bash
composer require tipoff/staff-bookings
```

Register the tool in `NovaServiceProvider`:

```php
public function tools()
{
    return [
        // ...
        new \Tipoff\StaffBookings\StaffBookings,
    ];
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tipoff](https://github.com/tipoff)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
