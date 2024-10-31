<?php

namespace App\Filament\Resources\JupyterNotebookResource\Pages;

use App\Filament\Resources\JupyterNotebookResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\View\View;

class ListJupyterNotebooks extends ListRecords
{
    protected static string $resource = JupyterNotebookResource::class;

    protected static string $view = 'filament.resources.jupyter-iframe';

    public function mount(): void
    {
        parent::mount();
        Artisan::call('import:jupyter-files');
    }
}
