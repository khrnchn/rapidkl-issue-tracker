<?php

namespace App\Livewire;

use App\Enums\CategoryEnum;
use App\Enums\PriorityEnum;
use App\Enums\StatusEnum;
use App\Models\Issue;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use JaOcero\ActivityTimeline\Components\ActivityDate;
use JaOcero\ActivityTimeline\Components\ActivityDescription;
use JaOcero\ActivityTimeline\Components\ActivityIcon;
use JaOcero\ActivityTimeline\Components\ActivitySection;
use JaOcero\ActivityTimeline\Components\ActivityTitle;
use Livewire\Component;

class ListIssues extends Component implements HasTable, HasForms, HasInfolists
{
    use InteractsWithTable, InteractsWithForms, InteractsWithInfolists;

    public function render()
    {
        return view('livewire.list-issues');
    }

    public function table(Table $table): Table
    {
        return $table
            // ->paginated(false)
            ->query(Issue::query())
            ->columns([
                Stack::make([
                    TextColumn::make('title')
                        ->searchable()
                        ->wrap()
                        ->description(fn (Issue $record): string => $record->description)
                        ->weight(FontWeight::Bold),

                    View::make('linebreak'),

                    TextColumn::make('category')
                        ->icon('heroicon-m-exclamation-triangle')
                        ->formatStateUsing(function ($state) {
                            return CategoryEnum::getDescription($state);
                        }),

                    TextColumn::make('created_at')
                        ->icon('heroicon-o-clock')
                        ->formatStateUsing(function ($state) {
                            return Carbon::parse($state)->diffForHumans();
                        }),

                    View::make('linebreak'),

                    Split::make([
                        TextColumn::make('status')
                            ->badge()
                            ->grow(false)
                            ->color(fn (int $state): string => match ($state) {
                                StatusEnum::REPORTED => 'danger',
                                StatusEnum::IN_PROGRESS => 'warning',
                                StatusEnum::RESOLVED => 'success',
                            })
                            ->icon(fn (int $state): string => match ($state) {
                                StatusEnum::REPORTED => 'heroicon-o-pencil',
                                StatusEnum::IN_PROGRESS => 'heroicon-o-cube',
                                StatusEnum::RESOLVED => 'heroicon-o-check-circle',
                            })
                            ->formatStateUsing(function ($state) {
                                if ($state == StatusEnum::REPORTED) {
                                    return 'reported';
                                } elseif ($state == StatusEnum::IN_PROGRESS) {
                                    return 'in progress';
                                } else {
                                    return 'resolved';
                                }
                            }),
                        // TextColumn::make('category')
                        //     ->badge()
                        //     ->grow(false)
                        //     ->color(fn (int $state): string => match ($state) {
                        //         CategoryEnum::BREAKDOWN => 'danger',
                        //         CategoryEnum::DELAY => 'warning',
                        //         CategoryEnum::SERVICE_DISRUPTION => 'gray',
                        //     })
                        //     ->formatStateUsing(function ($state) {
                        //         if ($state == CategoryEnum::BREAKDOWN) {
                        //             return 'breakdown';
                        //         } elseif ($state == CategoryEnum::DELAY) {
                        //             return 'delay';
                        //         } else {
                        //             return 'service disruption';
                        //         }
                        //     }),
                        TextColumn::make('priority')
                            ->badge()
                            ->grow(false)
                            ->color(fn (int $state): string => match ($state) {
                                PriorityEnum::LOW => 'success',
                                PriorityEnum::MEDIUM => 'warning',
                                PriorityEnum::HIGH => 'danger',
                            })
                            ->formatStateUsing(function ($state) {
                                if ($state == PriorityEnum::LOW) {
                                    return 'low';
                                } elseif ($state == PriorityEnum::MEDIUM) {
                                    return 'medium';
                                } else {
                                    return 'high';
                                }
                            }),

                    ]),

                    // TextColumn::make('user_id')->label(('Reported by'))
                    //     ->formatStateUsing(function ($state) {
                    //         $user = User::where('id', $state)->value('name');

                    //         return $user;
                    //     }),
                ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->icon('heroicon-m-square-3-stack-3d')
                    ->color('primary')
                    ->model(Issue::class)
                    ->form([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('title')->required()->columnSpan(3),
                                Textarea::make('description')->required()->columnSpan(3)->rows(3),
                                Select::make('status')->required()->native(false)->columnSpan(1)
                                    ->options([
                                        StatusEnum::REPORTED => 'Reported',
                                        StatusEnum::IN_PROGRESS => 'In Progress',
                                    ]),
                                Select::make('category')->required()->native(false)->columnSpan(1)
                                    ->options([
                                        CategoryEnum::BREAKDOWN => 'Breakdown',
                                        CategoryEnum::DELAY => 'Delay',
                                        CategoryEnum::SERVICE_DISRUPTION => 'Service Disruption',
                                    ]),
                                Select::make('priority')->required()->native(false)->columnSpan(1)
                                    ->options([
                                        PriorityEnum::LOW => 'Low',
                                        PriorityEnum::MEDIUM => 'Medium',
                                        PriorityEnum::HIGH => 'High',
                                    ]),
                            ]),

                    ])
                    ->using(function (array $data, string $model): Issue {
                        $data['user_id'] = 1;

                        return $model::create($data);
                    })
            ])
            ->filters([
                Filter::make('breakdown')
                    ->query(fn (Builder $query): Builder => $query->where('category', CategoryEnum::BREAKDOWN)),

                Filter::make('delay')
                    ->query(fn (Builder $query): Builder => $query->where('category', CategoryEnum::DELAY)),

                Filter::make('service_discruption')
                    ->query(fn (Builder $query): Builder => $query->where('category', CategoryEnum::SERVICE_DISRUPTION)),

                Filter::make('created_at')
                    ->default()
                    ->form([
                        DatePicker::make('created_from')
                            ->default(now()->startOfDay()),
                        DatePicker::make('created_until')
                            ->default(now()),
                    ])
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['created_from'] ?? null) {
                            $indicators[] = Indicator::make('Happened from ' . Carbon::parse($data['created_from'])->toFormattedDateString())
                                ->removeField('created_from');
                        }

                        if ($data['created_until'] ?? null) {
                            $indicators[] = Indicator::make('Happened until ' . Carbon::parse($data['created_until'])->toFormattedDateString())
                                ->removeField('created_until');
                        }

                        return $indicators;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->emptyStateDescription('Apparently there are no issues for now...');
    }
}
