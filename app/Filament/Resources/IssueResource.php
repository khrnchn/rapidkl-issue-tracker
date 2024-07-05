<?php

namespace App\Filament\Resources;

use App\Enums\StatusEnum;
use App\Enums\CategoryEnum;
use App\Enums\PriorityEnum;
use App\Filament\Resources\IssueResource\Pages;
use App\Filament\Resources\IssueResource\RelationManagers;
use App\Filament\Resources\IssueResource\Widgets\StatsOverview;
use App\Models\Issue;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IssueResource extends Resource
{
    protected static ?string $model = Issue::class;

    protected static ?string $navigationIcon = 'heroicon-m-square-3-stack-3d';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
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
                    ])->columnSpan(2)->columns(3),

                Section::make('Others')
                    ->schema([
                        FileUpload::make('image'),
                    ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->description(fn (Issue $record): string => $record->description)
                    ->weight(FontWeight::Bold),
                TextColumn::make('status')
                    ->badge()
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

                TextColumn::make('user_id')->label(('Reported by'))
                    ->formatStateUsing(function ($state) {
                        $user = User::where('id', $state)->value('name');

                        return $user;
                    }),
            ])
            ->filters([
                Filter::make('breakdown')
                    ->query(fn (Builder $query): Builder => $query->where('category', CategoryEnum::BREAKDOWN)),

                Filter::make('delay')
                    ->query(fn (Builder $query): Builder => $query->where('category', CategoryEnum::DELAY)),

                Filter::make('service_discruption')
                    ->query(fn (Builder $query): Builder => $query->where('category', CategoryEnum::SERVICE_DISRUPTION)),

                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until')
                            ->default(now()),
                    ])
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
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateDescription('Apparently there are no issues for now...');
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
            'index' => Pages\ListIssues::route('/'),
            'create' => Pages\CreateIssue::route('/create'),
            'edit' => Pages\EditIssue::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
}
