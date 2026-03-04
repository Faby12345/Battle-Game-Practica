<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BattleController;

Route::post('/battle', [BattleController::class, 'play']);
