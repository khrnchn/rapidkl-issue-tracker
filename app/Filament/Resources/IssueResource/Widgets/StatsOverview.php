<?php

namespace App\Filament\Resources\IssueResource\Widgets;

use App\Enums\StatusEnum;
use App\Models\Issue;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Issues raised', Issue::count()),
            Stat::make('Issues resolved', Issue::where('status', StatusEnum::RESOLVED)->count()),
            Stat::make('Issues today', Issue::whereDate('created_at', Carbon::today())->count()),
        ];
    }
}
