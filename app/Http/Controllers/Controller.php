<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Hgraph;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function show(){
        $records = session('selectedRecords', collect());

        return view('filament.pages.view-selected', compact('records'));
    }
}
