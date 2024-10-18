<?php

namespace DesignTheBox\BarcodeField\Forms\Components;

use Filament\Forms\Components\TextInput;

class BarcodeInput extends TextInput
{
    protected string $view = 'barcode-field::components.barcode-input'; // View namespaced correctly

    protected function setUp(): void
    {
        parent::setUp();

        // Set default properties for the BarcodeInput
        $this->label('Barcode Input')
            ->placeholder('Enter barcode...')
            ->required(); // Set as required if needed
    }
}
