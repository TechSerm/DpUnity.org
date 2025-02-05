<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembersResource\Pages;
use App\Filament\Resources\MembersResource\RelationManagers;
use App\Models\Member;
use App\Services\Image\ImageService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;

class MembersResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        // Return false to disable the "Create" button
        return false;
    }

    public function handleFileUpload(Member $member, $data): void
    {
        $imageService = new ImageService($member->image);
        $signatureService = new ImageService($member->signature);

        if (isset($data['image'])) {
            $image = $imageService->createAndReplace('image');
            $member->image_id = $image ? $image->id : $member->image_id;
        }

        if (isset($data['signature'])) {
            $signature = $signatureService->createAndReplace('signature');
            $member->signature_id = $signature ? $signature->id : $member->signature_id;
        }

        $member->save();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('organization_id')
                                    ->label('প্রতিষ্ঠানের আইডি')
                                    ->required()
                                    ->placeholder('প্রতিষ্ঠানের আইডি'),

                                Forms\Components\Select::make('category')
                                    ->label('ক্যাটেগরি')
                                    ->options([
                                        'soddosho' => 'সদস্য',
                                        'data_soddosho' => 'দাতা সদস্য',
                                        'shohojoddha' => 'সহযোদ্ধা',
                                        'shuvokankkhi' => 'শুভাকাঙ্ক্ষী',
                                    ])
                                    ->required()
                                    ->placeholder('-- ক্যাটেগরি নির্বাচন করুন --'),

                                Forms\Components\Select::make('is_approved')
                                    ->label('অবস্থা')
                                    ->options([
                                        '0' => 'Pending',
                                        '1' => 'Approved',
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('name')
                                    ->label('নাম')
                                    ->required()
                                    ->placeholder('নাম'),

                                Forms\Components\TextInput::make('father_name')
                                    ->label('পিতার নাম')
                                    ->required()
                                    ->placeholder('পিতার নাম'),

                                Forms\Components\TextInput::make('mother_name')
                                    ->label('মাতার নাম')
                                    ->required()
                                    ->placeholder('মাতার নাম'),
                            ]),
                    ]),

                Forms\Components\Section::make('Personal Details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('date_of_birth')
                                    ->label('জন্ম তারিখ')
                                    ->required(),

                                Forms\Components\Select::make('nationality')
                                    ->label('জাতীয়তা')
                                    ->options([
                                        'Bangladeshi' => 'বাংলাদেশী',
                                        'Indian' => 'ভারতীয়',
                                        'Pakistani' => 'পাকিস্তানি',
                                        'Nepalese' => 'নেপালী',
                                        'Sri Lankan' => 'শ্রীলঙ্কান',
                                        'Other' => 'অন্যান্য',
                                    ])
                                    ->required()
                                    ->placeholder('-- জাতীয়তা নির্বাচন করুন --'),

                                Forms\Components\Select::make('religion')
                                    ->label('ধর্ম')
                                    ->options([
                                        'Islam' => 'ইসলাম',
                                        'Hinduism' => 'হিন্দু ধর্ম',
                                        'Christianity' => 'খ্রিস্টধর্ম',
                                        'Buddhism' => 'বৌদ্ধধর্ম',
                                        'Other' => 'অন্যান্য',
                                    ])
                                    ->required()
                                    ->placeholder('-- ধর্ম নির্বাচন করুন --'),

                                Forms\Components\TextInput::make('occupation')
                                    ->label('পেশা')
                                    ->required()
                                    ->placeholder('উদাহরণ: প্রবাসী'),

                                Forms\Components\TextInput::make('nid')
                                    ->label('জাতীয় পরিচয়পত্র (এনআইডি)')
                                    ->placeholder('জাতীয় পরিচয়পত্র নম্বর'),

                                Forms\Components\TextInput::make('mobile')
                                    ->label('মোবাইল নম্বর')
                                    ->tel()
                                    ->required(),
                            ]),

                        Forms\Components\Textarea::make('present_address')
                            ->label('বর্তমান ঠিকানা')
                            ->required()
                            ->rows(2),

                        Forms\Components\Textarea::make('permanent_address')
                            ->label('স্থায়ী ঠিকানা')
                            ->required()
                            ->rows(2),

                        Forms\Components\Select::make('blood_group')
                            ->label('রক্তের গ্রুপ')
                            ->options([
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                                'O+' => 'O+',
                                'O-' => 'O-',
                            ])
                            ->placeholder('রক্তের গ্রুপ নির্বাচন করুন'),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('ছবি')
                            ->image()
                            ->directory('member-images')
                            ->preserveFilenames()
                            ->default(fn ($record) => $record?->image_url),

                        Forms\Components\FileUpload::make('signature')
                            ->label('স্বাক্ষর')
                            ->image()
                            ->directory('member-signatures')
                            ->preserveFilenames(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('organization_id')
                    ->label('Id')
                    ->sortable(),
                ImageColumn::make('image.url')
                    ->square()
                    ->width(70)
                    ->height(70)
                    ->defaultImageUrl(url('images/default-avatar.png')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mobile')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_approved')
                    ->label('Approval Status')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Approved' : 'Pending')
                    ->colors([
                        'success' => fn($state) => $state == true, // Green for "Approved"
                        'danger' => fn($state) => $state == false, // Red for "Pending"
                    ]),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_approved')->label('Approval Status')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMembers::route('/'),
        ];
    }
}
