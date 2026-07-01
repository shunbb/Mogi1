<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{id}', [ItemController::class, 'show']);
Route::get('/purchase/{id}', [ItemController::class, 'purchase']);
Route::post('/purchase/{id}', [ItemController::class, 'buy']);
Route::get('/address/{id}', [ItemController::class, 'editAddress']);
Route::post('/address/{id}', [ItemController::class, 'updateAddress']);