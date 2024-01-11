<?php

use App\Http\Controllers\Admin\ActivitiesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserActivitiesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\UsersController as NormalUsersController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::middleware(['not_admin'])->group(function () {
        //-----User----------------------------------------------------------------------------------------------------//
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/activities', [NormalUsersController::class, 'getActivities'])->name('user.activities');
    });

    //-----Admin----------------------------------------------------------------------------------------------------//
    Route::prefix('dashboard')->middleware(['is_admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        //-----Activities----------------------------------------------------------------------------------------------------//
        Route::get('/activities', [ActivitiesController::class, 'index'])->name('dashboard.activities');
        Route::get('/activities/create', [ActivitiesController::class, 'create'])->name('activities.create');
        Route::post('/activities/store', [ActivitiesController::class, 'store'])->name('activities.store');
        Route::get('/activities/{id}', [ActivitiesController::class, 'show'])->name('activities.show');
        Route::get('/activities/{id}/edit', [ActivitiesController::class, 'edit'])->name('activities.edit');
        Route::put('/activities/{id}', [ActivitiesController::class, 'update'])->name('activities.update');
        Route::delete('/activities/{id}', [ActivitiesController::class, 'destroy'])->name('activities.destroy');

        //-----Users----------------------------------------------------------------------------------------------------//
        Route::get('/users', [UsersController::class, 'index'])->name('dashboard.users');
        Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');

        //-----User Activities----------------------------------------------------------------------------------------------------//
        Route::get('/users/{id}/activities/create', [UserActivitiesController::class, 'create'])->name('users.activities.create');
        Route::get('/users/{userId}/activities/{id}', [UserActivitiesController::class, 'show'])->name('users.activities.show');
        Route::post('/users/{id}/activities/store', [UserActivitiesController::class, 'store'])->name('users.activities.store');
        Route::get('/users/{userId}/activities/{id}/edit', [UserActivitiesController::class, 'edit'])->name('users.activities.edit');
        Route::put('/users/{userId}/activities/{id}', [UserActivitiesController::class, 'update'])->name('users.activities.update');
        Route::delete('/users/{userId}/activities/{id}', [UserActivitiesController::class, 'destroy'])->name('users.activities.destroy');
    });
});
