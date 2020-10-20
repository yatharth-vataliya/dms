<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\FileController;
use App\Http\Livewire\FileHandling;
use \App\Http\Controllers\DashboardController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
	Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
	Route::resource('/access',AccessController::class);
	// Route::resource('/file',FileController::class);
	Route::get('/file/index',FileHandling::class)->name('file.index');
});
