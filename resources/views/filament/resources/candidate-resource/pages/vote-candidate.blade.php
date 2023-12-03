<x-filament-panels::page>
    <x-filament-panels::form wire:submit="submit">
        {{ $this->form }}
        <div>
            @if(!auth()->user()->has_chosen)
                <x-filament::button type="submit" size="sm">
                    Pilih
                </x-filament::button>
            @endif
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
