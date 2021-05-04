<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ {
    BalanceController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/get-balance/{user_id}', [BalanceController::class, 'get'])->where(['user_id' => '[0-9]+']);
Route::post('/add-money', [BalanceController::class, 'addMoney']);
