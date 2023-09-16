<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::post('/add_user', [UserController::class, 'addUser']);
Route::get('/user/{id}', [UserController::class, 'getSingleUser']);
Route::put('/user/{id}/update', [UserController::class, 'updateUser']);
Route::delete('/user/{id}/delete', [UserController::class, 'deleteUser']);