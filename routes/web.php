<?php

use App\Filament\Pages\Compare;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// route for response with download file
Route::get('/download/{file}', function ($file) {
    $p = '/app/public/datasets/'.$file.'/'.$file.'.hgf';
    # concat file again to p
    $path = storage_path($p);
    # console.log($path
    // return response()->download($path);
    if (file_exists($path)) {
        return response()->download($path);
    }
    return response()->json(['message' => 'File not found!'], 404);
});

Route::get('/compare/{ids}', Compare::class)->name('filament.pages.compare');
