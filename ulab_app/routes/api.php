<?php

use App\Http\Controllers\FormsConstructorController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\RequestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/forms/getFields", [FormsController::class, 'getFieldsForm']);

Route::post('saveRequest', [RequestController::class, 'insertUpdate']);

Route::get('getRooms', [RoomController::class, 'journalRooms']);
Route::post('saveRoom', [RoomController::class, 'save']);

Route::get('/modules', [ModuleController::class, 'getRolesAndPermissions']);

Route::get('/constructor/forms', [FormsConstructorController::class, 'getAllModuleForms']);
Route::post('/constructor/updateSystemFieldsForm', [FormsConstructorController::class, 'updateFormFields']);

Route::get('/test', function () {
    return response()->json([
        'message' => 'Backend работает!',
    ]);
});
