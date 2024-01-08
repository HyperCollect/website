<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Info extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.info';

    protected static ?int $navigationSort = 100;
}
