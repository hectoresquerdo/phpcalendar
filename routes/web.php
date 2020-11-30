<?php

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

/*Route::get('/', function () {
    return view('eventos/index');
});*/
Route::get('/', [App\Http\Controllers\EventosController::class, 'index']);

Auth::routes();

use App\Http\Controllers\EventosController;

Route::resource('eventos',EventosController::class);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
