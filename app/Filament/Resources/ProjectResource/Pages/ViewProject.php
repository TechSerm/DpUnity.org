<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Grid;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    private string $activeTab = 'details'; // Default active tab

    public function infolist(Infolist $infolist): Infolist
    {
        // Dynamically load schema based on active tab
        $schemas = [
            'details' => [
                Section::make('Project Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Project Title'),
                                TextEntry::make('start_date')
                                    ->label('Start Date')
                                    ->date(),
                                TextEntry::make('end_date')
                                    ->label('End Date')
                                    ->date(),
                            ]),
                        TextEntry::make('description')
                            ->label('Project Description')
                            ->prose(),
                    ]),
            ],
            'overview' => [
                Section::make('Overview')
                    ->schema([
                        TextEntry::make('summary')
                            ->label('Summary'),
                        TextEntry::make('status')
                            ->label('Status'),
                    ]),
            ],
            'members' => [
                Section::make('Project Members')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('member_name')
                                    ->label('Member Name'),
                                TextEntry::make('role')
                                    ->label('Role'),
                            ]),
                    ]),
            ],
            'tasks' => [
                Section::make('Project Tasks')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('task_title')
                                    ->label('Task Title'),
                                TextEntry::make('assigned_to')
                                    ->label('Assigned To'),
                                TextEntry::make('status')
                                    ->label('Status'),
                            ]),
                    ]),
            ],
        ];

        return $infolist->schema($schemas[$this->activeTab] ?? $schemas['details']);
    }

    public function getTabs(): array
    {
        return [
            'details' => [
                'label' => 'Project Details',
                'icon' => 'heroicon-o-information-circle',
            ],
            'overview' => [
                'label' => 'Overview',
                'icon' => 'heroicon-o-eye',
            ],
            'members' => [
                'label' => 'Project Members',
                'icon' => 'heroicon-o-users',
            ],
            'tasks' => [
                'label' => 'Project Tasks',
                'icon' => 'heroicon-o-clipboard-document-list',
            ],
        ];
    }

    /**
     * Custom method to handle tab switching logic.
     */
    public function setActiveTab(string $tab): void
    {
        $this->activeTab = $tab;
    }
}
