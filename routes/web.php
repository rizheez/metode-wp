<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/data', [DataController::class, 'index'])->name('data');
Route::get('/alternatif', [AlternatifController::class, 'index'])->name('alternatif');
Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria');
Route::get('/metodewp', [DataController::class, 'calculateWP'])->name('metodewp');
Route::get('/hasil', [DataController::class, 'show'])->name('hasil');
Route::get('/kriteria/deleteAll', [KriteriaController::class, 'destroy'])->name('kriteria.delete');
Route::get('/alternatif/deleteAll', [AlternatifController::class, 'destroy'])->name('alternatif.delete');
Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
Route::put('/alternatif/{id}', [AlternatifController::class, 'update'])->name('alternatif.update');
Route::get('kriteria/{id}', [KriteriaController::class, 'edit'])->name('kriteria.edit');
Route::get('/alternatif/{id}', [AlternatifController::class, 'edit'])->name('alternatif.edit');

Route::post('/alternatif', [AlternatifController::class, 'store'])->name('alternatif.store');
Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
Route::post('/data', [DataController::class, 'store'])->name('dataal');
