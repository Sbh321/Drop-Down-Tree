<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/linux/old', [App\Http\Controllers\LinuxController::class, 'showOld']);

Route::delete('/linux/cascade/{id}', [App\Http\Controllers\LinuxController::class, 'deleteCascade']);

YajTech\Crud\Helper\CrudRoute::generateRoutes('linux', App\Http\Controllers\LinuxController::class);
