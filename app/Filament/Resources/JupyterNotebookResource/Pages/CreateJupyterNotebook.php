<?php

namespace App\Filament\Resources\JupyterNotebookResource\Pages;

use App\Filament\Resources\JupyterNotebookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJupyterNotebook extends CreateRecord
{
    protected static string $resource = JupyterNotebookResource::class;
}
