<?php
namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $view = 'filament.pages.settings';
    public $WEBSITE_TITLE;

    public $settings = [];

    public function mount()
    {

        $this->settings = DB::table('settings')->pluck('value', 'key')->toArray();
        $this->settings['WEBSITE_TITLE'] = json_decode($this->settings['WEBSITE_TITLE'], true);
        $this->form->fill($this->settings);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Website')
                        ->id('website')
                        ->schema([
                            Forms\Components\FileUpload::make('WEBSITE_TITLE')
                                ->label('Website Logo')
                                ->image()
                                ->directory('site-logos')
                                ->visibility('public')
                                ->multiple()
                                ->imageEditor()
                                ->maxFiles(5)
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth('300')
                                ->imageResizeTargetHeight('150')
                                ->panelLayout('grid')
                                ->helperText('Upload your website logo (recommended size: 300x150)'),
                        ]),
                    Forms\Components\Tabs\Tab::make('General')
                        ->id('general')
                        ->schema([
                            Forms\Components\TextInput::make('SITE_DESCRIPTION')
                                ->label('Site Description')
                                ->helperText('A brief description of your website'),
                        ])
                ])
        ];
    }

    public function save()
    {

        // Loop through the form data and update the database
        foreach ($this->form->getState() as $key => $value) {
            DB::table('settings')
                ->where('key', $key)
                ->update(['value' => json_encode($value)]);
        }

        // Notify user
       // $this->notify('success', 'Settings saved successfully!');
    }
}