<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BattleController;

Route::post('/battle', [BattleController::class, 'play']);
Route::get('/battles', [BattleController::class, 'index']);
// test the connnection
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working',
        'success' => true,
    ]);
});
