<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxCrudController;
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

Route::get('/', [AjaxCrudController::class, 'index']);
Route::post('/store', [AjaxCrudController::class, 'store'])->name('store');
Route::get('/fetchAll', [AjaxCrudController::class, 'fetchAll'])->name('fetchAll');
Route::post('/edit', [AjaxCrudController::class, 'edit'])->name('edit');
Route::post('/update', [AjaxCrudController::class, 'update'])->name('update');
Route::post('/delete', [AjaxCrudController::class, 'delete'])->name('delete_data');
Route::get('/search', [AjaxCrudController::class, 'search'])->name('search');
