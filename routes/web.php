<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;

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
    return redirect('/login');
});

Route::get('dashboard', [EventController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::post('event', [EventController::class, 'create'])->middleware(['auth'])->name('dashboard.create');
Route::delete('event/{event}', [EventController::class, 'delete'])->middleware(['auth'])->name('dashboard.delete');

Route::resource('room', RoomController::class)->only([
    'index', 'create', 'update', 'destroy', 'store', 'edit'
]);

Route::get('room/new', [RoomController::class, 'new'])->middleware(['auth'])->name('room.new');
Route::get('users/list', [UserController::class, 'index'])->middleware(['auth'])->name('user.list');
Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware(['auth'])->name('user.destroy');

require __DIR__.'/auth.php';
