<?php

namespace DesignTheBox\BarcodeField;

use DesignTheBox\BarcodeField\Forms\Components\BarcodeInput;
use Filament\Forms\Components\Field;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentBarcodeScannerFieldServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-barcode-field';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
            ->hasViews(); // Tell Laravel that this package has views
    }

    public function bootingPackage(): void
    {
        // Register the views path
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'barcode-field'); // 'barcode-field' is the view namespace

        // Register the BarcodeInput component as a macro on the Field class
        Field::macro('barcodeInput', function () {
            return new BarcodeInput; // Create an instance of BarcodeInput
        });
    }
}
