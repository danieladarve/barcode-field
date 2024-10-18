<?php

namespace DesignTheBox\BarcodeField\Forms\Components;

use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Log;

class BarcodeInput extends TextInput
{

    protected string $view = 'filament.plugins.components.barcode-input';
    protected function setUp(): void
    {
        parent::setUp();

        // Set default properties for the BarcodeInput
        $this->label('Barcode Input test')
            ->placeholder('Enter barcode...')
            ->required(); // Set as required if needed
    }

    public function getLabel(): string
    {
        if ($this->label instanceof Htmlable) {
            return $this->label->toHtml();
        }

        return $this->evaluate($this->label)
            ?? (string) str($this->getName())
                ->afterLast('.')
                ->kebab()
                ->replace(['-', '_'], ' ')
                ->title();
    }
}
