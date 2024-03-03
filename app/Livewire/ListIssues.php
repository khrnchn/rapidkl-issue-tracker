<?php

namespace App\Livewire;

use App\Enums\CategoryEnum;
use App\Enums\PriorityEnum;
use App\Enums\StatusEnum;
use App\Models\Issue;
use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListIssues extends Component implements HasTable, HasForms
{
    use InteractsWithTable, InteractsWithForms;

    public function render()
    {
        return view('livewire.list-issues');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Issue::query())
            ->columns([
                Stack::make([
                    TextColumn::make('title')
                        ->wrap()
                        ->description(fn (Issue $record): string => $record->description)
                        ->weight(FontWeight::Bold),

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
                            ->formatStateUsing(function ($state) {
                                if ($state == StatusEnum::REPORTED) {
                                    return 'reported';
                                } elseif ($state == StatusEnum::IN_PROGRESS) {
                                    return 'in progress';
                                } else {
                                    return 'resolved';
                                }
                            }),
                        TextColumn::make('category')
                            ->badge()
                            ->grow(false)
                            ->color(fn (int $state): string => match ($state) {
                                CategoryEnum::BREAKDOWN => 'danger',
                                CategoryEnum::DELAY => 'warning',
                                CategoryEnum::SERVICE_DISRUPTION => 'gray',
                            })
                            ->formatStateUsing(function ($state) {
                                if ($state == CategoryEnum::BREAKDOWN) {
                                    return 'breakdown';
                                } elseif ($state == CategoryEnum::DELAY) {
                                    return 'delay';
                                } else {
                                    return 'service disruption';
                                }
                            }),
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
            ->contentGrid([
                's' => 2,
                'md' => 3,
                'xl' => 4,
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
                                        StatusEnum::RESOLVED => 'Resolved',
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
            ]);
    }
}
