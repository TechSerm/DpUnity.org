<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'প্রকল্পের তালিকা';
    protected static ?string $navigationGroup = 'প্রকল্প';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Project Title')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('description')
                            ->label('Project Description')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                            ]),

                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date')
                            ->after('start_date'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Project')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('End Date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn ($query) => $query->where('end_date', '>=', now())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // You can add relation managers here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjects::route('/'),
            'view' => Pages\ViewProject::route('/{record}'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return $record->expenses()->count() === 0 && 
               $record->donations()->count() === 0;
    }

    public static function getDeleteModalHeading(Model $record): ?string
    {
        if ($record->expenses()->count() > 0 || $record->donations()->count() > 0) {
            return 'প্রকল্প মুছে ফেলা যাবে না';
        }

        return null;
    }

    public static function getDeleteModalDescription(Model $record): ?string
    {
        $messages = [];

        if ($record->expenses()->count() > 0) {
            $messages[] = 'এই প্রকল্পে ব্যয় রয়েছে এবং মুছে ফেলা যাবে না।';
        }

        if ($record->donations()->count() > 0) {
            $messages[] = 'এই প্রকল্পে জমা রয়েছে এবং মুছে ফেলা যাবে না।';
        }

        return implode(' ', $messages);
    }
}