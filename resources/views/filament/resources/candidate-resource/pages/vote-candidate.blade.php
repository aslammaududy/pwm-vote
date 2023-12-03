<x-filament-panels::page>
    <x-filament-panels::form wire:submit="submit">
        {{ $this->form }}
        <div>
            <x-filament::button type="submit" size="sm">
                Pilih
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
