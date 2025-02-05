<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectDonationResource\Pages;
use App\Models\Member;
use App\Models\Project;
use App\Models\ProjectDonation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectDonationResource extends Resource
{
    protected static ?string $model = ProjectDonation::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'প্রকল্পের জমার তালিকা';
    protected static ?string $navigationGroup = 'প্রকল্প';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('তথ্য')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('ধরন')
                                    ->options([
                                        'member' => 'Member',
                                        'unknown' => 'Unknown',
                                    ])
                                    ->required()
                                    ->live()
                                    ->reactive()
                                    ->afterStateUpdated(function (Forms\Set $set) {
                                        //$set('member_id', null);
                                        //$set('name', null);
                                        //$set('mobile', null);
                                        
                                    }),

                                Forms\Components\Select::make('member_id')
                                    ->label('মেম্বার')
                                    ->options(Member::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->visible(fn(Forms\Get $get) => $get('type') === 'member')
                                    ->required(fn(Forms\Get $get) => $get('type') === 'member')
                                    ->default(function (?array $state, ?ProjectDonation $record) {
                                        // If editing an existing record and it's a member donation
                                        return $record && $record->member_id ? $record->member_id : null;
                                    }),

                                Forms\Components\TextInput::make('name')
                                    ->label('নাম')
                                    ->visible(fn(Forms\Get $get) => $get('type') === 'unknown')
                                    ->required(fn(Forms\Get $get) => $get('type') === 'unknown'),

                                Forms\Components\TextInput::make('mobile')
                                    ->label('মোবাইল')
                                    ->tel()
                                    ->visible(fn(Forms\Get $get) => $get('type') === 'unknown')
                                    ->required(fn(Forms\Get $get) => $get('type') === 'unknown'),
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('আর্থিক তথ্য')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('project_id')
                                    ->label('প্রকল্প')
                                    ->options(Project::all()->pluck('title', 'id'))
                                    ->searchable()
                                    ->required(),
                                Forms\Components\TextInput::make('amount')
                                    ->label('পরিমাণ')
                                    ->numeric()
                                    ->prefix('৳')
                                    ->required(),


                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\RichEditor::make('note')
                            ->label('নোট')
                            ->nullable()
                            ->extraAttributes(['style' => 'max-height: 200px; min-height: 100px;'])
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                            ]),

                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            
                Tables\Columns\TextColumn::make('id')
                    ->label('জমা আইডি')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('member.image.url')
                    ->label('মেম্বারের ছবি')
                    ->square()
                    ->height(70)
                    ->width(70)
                    ->extraImgAttributes([
                        'class' => 'border border-gray-300 rounded',
                    ]),

                Tables\Columns\TextColumn::make('name')
                    ->label('নাম')
                    ->formatStateUsing(fn($record) => $record->member_id === 'member' ? $record->member?->name : $record->name)
                    ->searchable(),

                Tables\Columns\TextColumn::make('mobile')
                    ->label('মোবাইল')
                    ->formatStateUsing(fn($record) => $record->member_id === 'member' ? $record->member?->mobile : $record->mobile)
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('পরিমাণ')
                    ->money('BDT')
                    ->sortable(),

                Tables\Columns\TextColumn::make('project.title')
                    ->label('প্রকল্প')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('জমা করেছে'),

                Tables\Columns\TextColumn::make('when')
                    ->label('তারিখ')
                    ->dateTime()
                    ->sortable(),

                
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('ধরন')
                    ->options([
                        'member' => 'Member',
                        'unknown' => 'Unknown',
                    ]),
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'title')
                    ->label('প্রকল্প'),
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
               // Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjectDonations::route('/'),
        ];
    }
}
