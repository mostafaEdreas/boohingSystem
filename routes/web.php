<?php

use App\Http\Controllers\Dashboard\{RoomController,HotelController,DashboardController, SearchController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

 Route::get('/', function () {
        return redirect()->route('dashboard.index');
    })->name('index');
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class,'index'])->name('index');
    Route::resource('hotels', HotelController::class)->except('show');
    Route::resource('rooms', RoomController::class)->only(['create' ,'store','index']);
    Route::get('/search', [SearchController::class,'search'])->name('search');
});
