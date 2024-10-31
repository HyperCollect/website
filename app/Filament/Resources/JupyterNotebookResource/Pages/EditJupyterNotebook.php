<?php

namespace App\Filament\Resources\JupyterNotebookResource\Pages;

use App\Filament\Resources\JupyterNotebookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJupyterNotebook extends EditRecord
{
    protected static string $resource = JupyterNotebookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
