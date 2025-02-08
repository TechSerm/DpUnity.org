<?php

namespace App\Filament\Pages;

use App\Enums\data\SettingEnumData;
use App\Enums\SettingEnum;
use App\Models\Setting;
use App\Services\FormBuilder\FormComponentBuilder;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'System';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.settings';

    // Dynamic settings storage
    public array $settingsData = [];

    public function mount(): void
    {
        $existingSettings = Setting::onlyEnumData()->get()->pluck('value', 'key')->toArray();
        $this->form->fill($existingSettings);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema($this->getSettingsFormSchema())
            ->columns(1)
            ->statePath('settingsData');
    }

    protected function getSettingsFormSchema(): array
    {
        $groupedSettings = SettingEnumData::getGroupedSettings();
        
        // Create tabs for specific groups
        $tabs = [];

        foreach ($groupedSettings as $group => $subgroups) {
            $tab = Forms\Components\Tabs\Tab::make(ucfirst($group))
                ->icon($this->getGroupIcon($group))
                ->id($group);

            $groupComponents = [];

            foreach ($subgroups as $subgroup => $settings) {
                $subgroupComponents = [];

                foreach ($settings as $key => $setting) {
                    $component = $setting->buildFilamentFormComponent();
                    if ($component) {
                        $subgroupComponents[] = $component;
                    }
                }

                // Add section for subgroup if it has components
                if (!empty($subgroupComponents)) {
                    $groupComponents[] = Components\Section::make(ucfirst($subgroup))
                        ->schema($subgroupComponents)
                        ->columns(12);
                }
            }

            // Set tab schema
            $tab->schema($groupComponents);
            $tabs[] = $tab;
        }

        // Return tabs component
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs($tabs)
        ];
    }


    protected function getActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->color('primary')
                ->action('saveSettings')
        ];
    }

    public function saveSettings(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            if(! SettingEnum::hasKey($key)) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        metaData()->cache()->refresh();

        Notification::make()
            ->title('Settings Saved')
            ->success()
            ->send();
    }

    protected function getGroupIcon(string $group): ?string
    {
        return match ($group) {
            'general' => 'heroicon-o-cog-6-tooth',
            'contact' => 'heroicon-o-phone',
            'social' => 'heroicon-o-share',
            'appearance' => 'heroicon-o-paint-brush',
            default => 'heroicon-o-adjustments-horizontal'
        };
    }

    // Optional: Add method to customize tab colors
    protected function getTabColor(string $group): ?string
    {
        return match ($group) {
            'general' => 'primary',
            'contact' => 'success',
            'social' => 'info',
            'appearance' => 'warning',
            default => null
        };
    }
}
