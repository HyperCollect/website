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

    public function show($ids){
        $idsArray = explode(",", $ids);
        $selectedRecords = Hgraph::whereIn('id', $idsArray)->get();
        return view('filament.pages.compare', compact('selectedRecords'));
    }
}
