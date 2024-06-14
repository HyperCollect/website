<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\View\View;

class Compare extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.compare';

    public $recordIds;


    // Nascondi la pagina dal menu a sinistra
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
