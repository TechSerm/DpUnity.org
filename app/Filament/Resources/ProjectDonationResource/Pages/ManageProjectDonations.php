<?php

namespace App\Filament\Resources\ProjectDonationResource\Pages;

use App\Filament\Resources\ProjectDonationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProjectDonations extends ManageRecords
{
    protected static string $resource = ProjectDonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
