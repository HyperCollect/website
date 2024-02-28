<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Event;
use App\Models\Hgraph;
use App\Models\Communication;
// use Buildix\Timex\Resources\EventResource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Columns\BadgeColumn;
use App\Filament\Resources\EventResource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HgraphResource;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Console\Commands\MailNotificationCommand;
use Illuminate\Support\HtmlString;

class LatestHgraphs extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?string $pollingInterval = '3s';


    public static ?string $heading = 'Latest updated graphs';

    protected static ?int $sort = 1;

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'name';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    protected function getTableQuery(): Builder
    {

    //    $now = now()->modify('midnight'); 
    //    $end = now()->modify('midnight')->modify('+31 day');
      
      
       return HgraphResource::getEloquentQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->size(TextColumn\TextColumnSize::Large)
                ->weight(FontWeight::Bold),
            Tables\Columns\TextColumn::make('author')
                ->size(TextColumn\TextColumnSize::Large)
                ->searchable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('summary')
                ->size(TextColumn\TextColumnSize::Large)
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('domain')
                ->label('Category')
                ->size(TextColumn\TextColumnSize::Large)
                ->badge()
                ->searchable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('categories.type')
                ->label('Type')    
                ->size(TextColumn\TextColumnSize::Large)
                ->badge()
                ->searchable(),
            Tables\Columns\TextColumn::make('nodes')
                ->label('|V|')
                ->size(TextColumn\TextColumnSize::Large)
                ->numeric()
                ->searchable()
                ->sortable()
                ->alignment(Alignment::End),
            Tables\Columns\TextColumn::make('edges')
                ->numeric()
                ->size(TextColumn\TextColumnSize::Large)
                ->label('|E|')
                ->sortable()
                ->alignment(Alignment::End),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated at')
                ->size(TextColumn\TextColumnSize::Large)
                ->dateTime()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created at')
                ->size(TextColumn\TextColumnSize::Large)
                ->dateTime()
                ->sortable()
                ->toggleable(),
            Tables\Columns\TextColumn::make('dnodemax')
                ->numeric()
                ->size(TextColumn\TextColumnSize::Large)
                ->toggleable(isToggledHiddenByDefault: true)
                ->label(fn() => new HtmlString('d<sub>max</sub>'))
                ->sortable()
                ->alignment(Alignment::End),
            Tables\Columns\TextColumn::make('dedgemax')
                ->numeric()
                ->size(TextColumn\TextColumnSize::Large)
                ->label(fn() => new HtmlString('e<sub>max</sub>'))
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->alignment(Alignment::End),
            Tables\Columns\TextColumn::make('dnodeavg')
                ->numeric()
                ->size(TextColumn\TextColumnSize::Large)
                ->label(fn() => new HtmlString('d<sub>avg</sub>'))
                ->sortable() ->toggleable(isToggledHiddenByDefault: true)
                ->alignment(Alignment::End),
            Tables\Columns\TextColumn::make('dedgeavg')
                ->numeric()
                ->size(TextColumn\TextColumnSize::Large)
                ->label(fn() => new HtmlString('e<sub>avg</sub>'))
                ->sortable() ->toggleable(isToggledHiddenByDefault: true)
                ->alignment(Alignment::End)
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')->label('')->icon('heroicon-m-eye')->color('secondary')
            ->url(fn (Hgraph $record): string => HgraphResource::getUrl('view', ['record' => $record])),
           
            // Tables\Actions\Action::make('edit')->label('')->icon('heroicon-m-pencil-square')
            //     ->url(fn (Event $record): string => EventResource::getUrl('edit', ['record' => $record])),
        ];
    }
}
