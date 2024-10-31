<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JupyterNotebookResource\Pages;
use App\Filament\Resources\JupyterNotebookResource\RelationManagers;
use App\Models\JupyterNotebook;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Artisan;
use Filament\Tables\Actions\Action;

class JupyterNotebookResource extends Resource
{
    protected static ?string $model = JupyterNotebook::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('path')->required()->default('/app/notebooks/'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('path')->sortable(),
            ])
            ->actions([
                Action::make('open')
                    ->label('Open')
                    ->button()
                    ->color('primary')
                    ->url('#')
                    ->extraAttributes(fn($record) => [
                        'data-url' => route('jupyter.view', ['path' => $record->path])
                    ]),
            ])
            ->headerActions([
                Action::make('Update notebook list')
                    ->label('Update notebook list')
                    ->action(function(){
                        Artisan::call('import:jupyter-files');
                    })
                    ->color('primary'),
                ]);
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
            'index' => Pages\ListJupyterNotebooks::route('/'),
            //'create' => Pages\CreateJupyterNotebook::route('/create'),
            //'edit' => Pages\EditJupyterNotebook::route('/{record}/edit'),
        ];
    }
}
