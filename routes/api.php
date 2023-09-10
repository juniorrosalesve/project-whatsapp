<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WhatsAppController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('msg')->group(function() {
    Route::post('receiver', [WhatsAppController::class, 'listen']);
    Route::post('send', [WhatsAppController::class, 'send']);
});