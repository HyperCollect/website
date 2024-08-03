<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Hgraph;

class Compare extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.compare';
    public $selectedRecords = [];

    public function mount()
    {
        $ids = request('ids');
        $this->selectedRecords = Hgraph::whereIn('id', explode(',', $ids))->get();
    }

    protected function getViewData(): array
    {
        return [
            'selectedRecords' => $this->selectedRecords,
        ];
    }

    // Nascondi la pagina dal menu a sinistra
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
