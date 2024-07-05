<?php

namespace App\Livewire;

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
            Stat::make('Issues raised today', Issue::whereDate('created_at', Carbon::today())->count())
                // ->description('32k increase')
                // ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Issues raised all time', Issue::count())
                // ->description('7% increase')
                // ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Issues resolved all time', Issue::where('status', StatusEnum::RESOLVED)->count())
                // ->description('3% increase')
                // ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
