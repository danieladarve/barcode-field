<!-- Include the ZXing Library and your custom barcode scanner script -->
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script src="{{ asset('vendor/barcode-field/barcode-scanner.js') }}"></script>
@php
    use Filament\Forms\Components\TextInput\Actions\HidePasswordAction;
    use Filament\Forms\Components\TextInput\Actions\ShowPasswordAction;

    $datalistOptions = $getDatalistOptions();
    $extraAlpineAttributes = $getExtraAlpineAttributes();
    $hasInlineLabel = $hasInlineLabel();
    $id = $getId();
    $isConcealed = $isConcealed();
    $isDisabled = $isDisabled();
    $isPasswordRevealable = $isPasswordRevealable();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $mask = $getMask();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();

    if ($isPasswordRevealable) {
        $xData = '{ isPasswordRevealed: false }';
    } elseif (count($extraAlpineAttributes) || filled($mask)) {
        $xData = '{}';
    } else {
        $xData = null;
    }

    if ($isPasswordRevealable) {
        $type = null;
    } elseif (filled($mask)) {
        $type = 'text';
    } else {
        $type = $getType();
    }
@endphp
<div xmlns:x-filament="http://www.w3.org/1999/html">
    <div class="grid gap-y-2">
        <div class="flex items-center gap-x-3 justify-between">
            <label for="{{ $getId() }}" class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    {{ $getLabel() ?? 'Input Label' }}
                    @if($isRequired())
                        <sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                    @endif
                </span>
            </label>
        </div>

        <x-filament::input.wrapper
            :x-data="$xData"
            onclick="openScannerModal()"
            class="relative cursor-pointer">
            <x-filament::input
                :attributes="
                \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                    ->merge($extraAlpineAttributes, escape: false)
                    ->merge([
                        'autocapitalize' => $getAutocapitalize(),
                        'autocomplete' => $getAutocomplete(),
                        'autofocus' => $isAutofocused(),
                        'disabled' => $isDisabled,
                        'id' => $id,
                        'name' => $getName(),
                        'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                        'inputmode' => $getInputMode(),
                        'list' => $datalistOptions ? $id . '-list' : null,
                        'max' => (! $isConcealed) ? $getMaxValue() : null,
                        'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                        'min' => (! $isConcealed) ? $getMinValue() : null,
                        'minlength' => (! $isConcealed) ? $getMinLength() : null,
                        'placeholder' => $getPlaceholder(),
                        'readonly' => $isReadOnly(),
                        'required' => $isRequired() && (! $isConcealed),
                        'step' => $getStep(),
                        'type' => $type,
                        $applyStateBindingModifiers('wire:model') => $statePath,
                        'x-bind:type' => $isPasswordRevealable ? 'isPasswordRevealed ? \'text\' : \'password\'' : null,
                        'x-mask' . ($mask instanceof \Filament\Support\RawJs ? ':dynamic' : '') => filled($mask) ? $mask : null,
                    ], escape: false)
                    ->class([
                        'pointer-events-none pl-8',
                        '[&::-ms-reveal]:hidden' => $isPasswordRevealable,
                    ])
                "
            />

            <!-- Trigger Button for Filament Modal -->
            <button type="button" class="absolute pl-2 inset-y-0 right-0 flex items-center pr-3 focus:outline-none" aria-label="Scan Barcode">
                @if($getExtraAttributes()['icon'] ?? null)
                    <span class="text-gray-400 dark:text-gray-200">
                        <x-dynamic-component :component="$getExtraAttributes()['icon']" class="w-5 h-5" />
                    </span>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 dark:text-gray-200" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M3 4h2v16H3V4zm4 0h2v16H7V4zm4 0h2v16h-2V4zm4 0h2v16h-2V4zm4 0h2v16h-2V4z"/>
                    </svg>
                @endif
            </button>
        </x-filament::input.wrapper>
    </div>

    <!-- Filament Modal for Barcode Scanner -->
    <x-filament::modal id="barcode-scanner-modal">
        <x-slot name="header">
            <h2 class="text-lg font-semibold">
                Scan Barcode
            </h2>
        </x-slot>

        <div class="p-4">
            <div id="scanner-container">
                <video id="scanner" autoplay class="rounded-lg shadow" style="display: none;"></video>
                <div class="overlay">
                    <div class="scan-area"></div>
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <x-filament::button onclick="closeScannerModal()" color="danger">
                Close
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</div>
