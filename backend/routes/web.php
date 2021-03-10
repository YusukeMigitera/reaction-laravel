<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReactionController;

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

Route::get('/', [ReactionController::class, 'page_index']);
Route::post('/confirm', [ReactionController::class, 'page_confirm']);
Route::post('/complete', [ReactionController::class, 'page_store']);
