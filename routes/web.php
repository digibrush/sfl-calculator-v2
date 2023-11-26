<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/','/admin/login');
Route::redirect('/login','/admin/login');

Route::get('/testing', 'App\Http\Controllers\TestController@test');

Route::get('/products/export', 'App\Http\Controllers\ExportController@export');

Route::get('/quote/{id}/duplicate', 'App\Http\Controllers\QuoteController@duplicate');
Route::get('/quote/{id}/template', 'App\Http\Controllers\QuoteController@template');
Route::get('/quote/{id}/convert', 'App\Http\Controllers\QuoteController@convert');
Route::get('/quote/{id}/create-simulation', 'App\Http\Controllers\QuoteController@simulation');
Route::get('/quote/{id}/generate-pdf', 'App\Http\Controllers\PdfController@generate');

Route::get('/simulator/simulations/{id}/select-all', 'App\Http\Controllers\SimulatorController@selectAll');
Route::get('/simulator/simulations/{id}/deselect-all', 'App\Http\Controllers\SimulatorController@deselectAll');
Route::get('/simulator/products/{id}/select', 'App\Http\Controllers\SimulatorController@selectProduct');
Route::get('/simulator/solutions/{id}/select', 'App\Http\Controllers\SimulatorController@selectSolution');
Route::get('/simulator/projects/{id}/select', 'App\Http\Controllers\SimulatorController@selectProject');
