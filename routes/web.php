<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReservationController;

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

Route::get('/', function () {
    return view('tasks');
});
Route::get('/fetch', [PlaceController::class, 'fetchInsert'])->name('fetch');
Route::get('/places', [PlaceController::class, 'show'])->name('places');
Route::get('/reservation-form', [ReservationController::class, 'showForm'])->name('reservation-form');
Route::post('/reservations', [ReservationController::class, 'store']);

