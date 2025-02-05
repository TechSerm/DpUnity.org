<style>
    .save-settings-container {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: white;
        padding: 15px;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        z-index: 10;
        text-align: right;
    }
    .filament-body {
        padding-bottom: 80px;
    }
</style>

<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="save-settings-container">
            <x-filament::button type="submit">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament::page>