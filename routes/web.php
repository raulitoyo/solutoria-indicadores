<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndicadorsController;
use App\Http\Controllers\ImportsController;
use App\Http\Controllers\ChartsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('indicadors', IndicadorsController::class);
Route::post('imports', [IndicadorsController::class, 'import'])->name('imports.import');
Route::post('charts', [ChartsController::class, 'index'])->name('charts.index');
