<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RequestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('saveRequest', [RequestController::class, 'insertUpdate']);

Route::get('/modules', [ModuleController::class, 'getRolesAndPermissions']);

Route::get('/test', function () {
    return response()->json([
        'message' => 'Backend работает!',
    ]);
});
