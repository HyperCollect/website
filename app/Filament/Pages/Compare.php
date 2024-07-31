<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Hgraph;
use Illuminate\Contracts\View\View;

class Compare extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.compare';
    public $selectedRecords = [];

    public function mount()
    {
        $this->selectedRecords = session()->pull('bulkActionData', []);
        //$this->selectedRecords = explode(",", $this->selectedRecords);
        $this->selectedRecords = Hgraph::whereIn('id', $this->selectedRecords)->get();
    }

    // Nascondi la pagina dal menu a sinistra
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
