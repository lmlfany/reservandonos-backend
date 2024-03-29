<?php

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlaceDetailController;
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
//Establecimientos Place
Route::get('/fetch', [PlaceController::class, 'fetchInsert'])->name('fetch');
Route::get('/places', [PlaceController::class, 'show'])->name('places');

// Reservaciones Reservations
Route::get('/reservation-form', [ReservationController::class, 'showForm'])->name('reservation-form');
Route::post('/reservation/{placeId}', [ReservationController::class, 'store']);
Route::get('/fetch-top-restaurants', [ReservationController::class, 'topRestaurants'])->name('fetch-top-restaurants');
Route::get('/top-restaurants', [ReservationController::class, 'showTop'])->name('top-restaurants');

//Detalle establecimiento Place detail
Route::get('/fetch-details', [PlaceDetailController::class, 'fetchInsert'])->name('fetch-details');
Route::get('/details', [PlaceDetailController::class, 'show'])->name('details');
//Vista
Route::get('/place-detail/{placeId}', [PlaceDetailController::class, 'showDetail'])->name('place-detail')->where('placeId', '[0-9]+');

//like
Route::get('/likes/fetchInsert', [LikeController::class, 'fetchInsert'])->name('likes.fetchInsert');
Route::post('/place/{placeId}/likes', [LikeController::class, 'store'])->name('place-likes-store');


