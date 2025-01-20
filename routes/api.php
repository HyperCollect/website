<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello', function () { # link/api/hello
    return response()->json(['message' => 'Hello World!'], 200);
});

# api to download a file with a specific name #/api/download/{name}
Route::get('/download/{name}', function ($name) {
    $path = storage_path('/app/public/datasets/' . $name . '/' . $name . '.hgf');
    if (!file_exists($path)) {
        return response()->json(['message' => 'File not found!'], 404);
    }
    return response()->download($path);
});