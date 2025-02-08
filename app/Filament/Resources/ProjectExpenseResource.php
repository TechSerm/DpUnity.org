<?php

namespace App\Filament\Resources;

use App\Enums\UploadDirectoryEnum;
use App\Filament\Resources\ProjectExpenseResource\Pages;
use App\Models\Project;
use App\Models\ExpenseCategory;
use App\Models\ProjectExpense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ProjectExpenseResource extends Resource
{
    protected static ?string $model = ProjectExpense::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'প্রকল্পের ব্যয়ের তালিকা';
    protected static ?string $navigationGroup = 'প্রকল্প';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('ব্যয়ের বিবরণ')
                    ->schema([
                        Forms\Components\Select::make('project_id')
                            ->label('প্রকল্প')
                            ->options(Project::all()->pluck('title', 'id'))
                            ->required()
                            ->searchable(),

                        Forms\Components\Select::make('expense_category_id')
                            ->label('ব্যয় বিভাগ')
                            ->options(ExpenseCategory::all()->pluck('title', 'id'))
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('title')
                            ->label('ব্যয়ের শিরোনাম')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('amount')
                            ->label('পরিমাণ')
                            ->numeric()
                            ->prefix('৳')
                            ->required(),

                        Forms\Components\RichEditor::make('description')
                            ->label('বিবরণ')
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

                        Forms\Components\FileUpload::make('attachment')
                            ->label('সংযুক্তি') // Attachments
                            ->multiple()
                            ->reorderable()
                            ->imageEditor()
                            ->maxFiles(10)
                            ->panelLayout('grid')
                            ->directory(UploadDirectoryEnum::PROJECT_EXPENCES)
                            ->visibility('private')
                            ->previewable()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/jpg',
                                'image/gif',
                                'image/bmp',
                            ])
                            ->deleteUploadedFileUsing(function ($file) {
                                $file = "public/".$file;
                                if (Storage::exists($file)) {
                                    Storage::delete($file);
                                }
                            })
                            ->maxSize(20240),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('id')
                    ->searchable(),

                Tables\Columns\TextColumn::make('project.title')
                    ->label('প্রকল্প')
                    ->badge()
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.title')
                    ->label('বিভাগ')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('ব্যয়ের শিরোনাম')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('পরিমাণ')
                    ->money('BDT')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('তারিখ')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project')
                    ->label('প্রকল্প')
                    ->relationship('project', 'title'),

                Tables\Filters\SelectFilter::make('expense_category')
                    ->label('ব্যয় বিভাগ')
                    ->relationship('category', 'title'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button()
                    ->color('info')
                    ->icon('heroicon-o-eye')
                    ->size('sm'), // View details

                Tables\Actions\EditAction::make()
                    ->button()
                    ->color('warning')
                    ->icon('heroicon-o-pencil')
                    ->size('sm'), // Edit information

                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->size('sm'), // Delete record
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('সব মুছুন')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->tooltip('সমস্ত নির্বাচিত রেকর্ড মুছে ফেলুন'), // Delete all selected records
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjectExpenses::route('/'),
            // 'create' => Pages\CreateProjectExpense::route('/create'),
            // 'edit' => Pages\EditProjectExpense::route('/{record}/edit'),
            // 'view' => Pages\ViewProjectExpense::route('/{record}'),
        ];
    }
}
