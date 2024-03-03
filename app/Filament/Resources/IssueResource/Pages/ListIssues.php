<?php

namespace App\Filament\Resources\IssueResource\Pages;

use App\Filament\Resources\IssueResource;
use App\Filament\Resources\IssueResource\Widgets\StatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIssues extends ListRecords
{
    protected static string $resource = IssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
