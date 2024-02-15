<?php

use App\Http\Controllers\InteractionController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceDetailController;
use App\Http\Controllers\ReservationController;
use App\Models\Interaction;

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
//Establecimientos Place
Route::get('/fetch', [PlaceController::class, 'fetchInsert'])->name('fetch');
Route::get('/places', [PlaceController::class, 'show'])->name('places');

// Reservaciones Reservations
Route::get('/reservation-form', [ReservationController::class, 'showForm'])->name('reservation-form');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations');

//Detalle establecimiento Place detail
Route::get('/fetch-details', [PlaceDetailController::class, 'fetchInsert'])->name('fetch-details');
Route::get('/details', [PlaceDetailController::class, 'show'])->name('details');
//Vista
Route::get('/place-detail/{placeId}', [PlaceDetailController::class, 'showDetail'])->name('place-detail')->where('placeId', '[0-9]+');

//like
Route::post('/place/{placeId}/likes', [LikeController::class, 'store'])->name('place-likes-store');

Route::get('/fetch-like', [LikeController::class, 'fetchInsert'])->name('fetch-like');
