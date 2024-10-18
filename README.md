# Filament Barcode Scanner Input

[![Latest Version on Packagist](https://img.shields.io/packagist/v/designthebox/barcode-field.svg?style=flat-square)](https://packagist.org/packages/designthebox/barcode-field)
[![Total Downloads](https://img.shields.io/packagist/dt/designthebox/barcode-field.svg?style=flat-square)](https://packagist.org/packages/designthebox/barcode-field)

## Overview

The **Filament Barcode Scanner Input** package provides a user-friendly barcode input field for your Filament applications. This component supports dynamic scanning, allowing users to input barcodes seamlessly.

## Installation

You can install the package via Composer:

```bash
composer require designthebox/barcode-field

```

## Usage

Once installed, you can use the BarcodeInput component in your Filament forms:

```php
 use DesignTheBox\BarcodeField\Forms\Components\BarcodeInput;

// In your form definition
BarcodeInput::make('barcode')
    ->icon('heroicon-o-arrow-right') // Specify your Heroicon name here
    ->required(),
```
##  Features

- Customizable icon using Heroicons.
- Responsive design for optimal use on various devices.
- Easy integration into your existing Filament forms.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Anthony Elleray](https://github.com/AElleray)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


### Key Enhancements
1. **Overview Section**: A brief description of what the package does.
2. **Features Section**: Highlight key features for quick reference.
3. **Consistency in Naming**: The package name is consistently formatted throughout the document.
4. **Formatting**: Clear formatting for code blocks and sections enhances readability.


