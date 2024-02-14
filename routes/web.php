<?php

use App\Http\Controllers\InteractionController;
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
Route::get('/fetch', [PlaceController::class, 'fetchInsert'])->name('fetch');
Route::get('/places', [PlaceController::class, 'show'])->name('places');
Route::get('/reservation-form', [ReservationController::class, 'showForm'])->name('reservation-form');
Route::post('/reservations', [ReservationController::class, 'store']);
Route::post('/like', [InteractionController::class, 'like']);

Route::get('/fetch-details', [PlaceDetailController::class, 'fetchInsert'])->name('fetch-details');
Route::get('/details', [PlaceDetailController::class, 'show'])->name('details');
// Route::get('/place-detail/{placeId}', [PlaceDetailController::class, 'showDetail'])->name('place-detail');
// Route::get('/place-detail/{placeId}', function () {
//     return view('place-detail');
// })->where('placeId', '[0-9]+');
Route::get('/place-detail/{placeId}', [PlaceDetailController::class, 'showDetail'])->name('place-detail')->where('placeId', '[0-9]+');
