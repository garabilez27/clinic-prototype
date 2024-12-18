<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\Authorized;
use App\Http\Middleware\Guest;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\ValueController;

Route::middleware(Authorized::class)->group(function() {
    Route::get('/terminate', [LoginController::class, 'logout'])->name('signout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menus
    Route::prefix('patients')->group(function() {
        Route::get('/', [PatientController::class, 'index'])->name('ptt.index');

        Route::post('/create', [PatientController::class, 'create'])->name('ptt.create');
        Route::post('/delete', [PatientController::class, 'destroy'])->name('ptt.delete');
        Route::post('/update', [PatientController::class, 'update'])->name('ptt.update');
    });

    Route::prefix('settings')->group(function() {
        Route::get('/', [SettingController::class, 'index'])->name('settings');

        // Menus
        Route::prefix('menus')->group(function() {
            Route::get('/', [MenuController::class, 'index'])->name('mn.index');

            Route::post('/create', [MenuController::class, 'create'])->name('mn.create');
            Route::post('/delete', [MenuController::class, 'destroy'])->name('mn.delete');
            Route::post('/update', [MenuController::class, 'update'])->name('mn.update');
        });

        // Sub Menus
        Route::prefix('subs')->group(function() {
            Route::get('/', [SubMenuController::class, 'index'])->name('sbmn.index');

            Route::post('/create', [SubMenuController::class, 'create'])->name('sbmn.create');
            Route::post('/delete', [SubMenuController::class, 'destroy'])->name('sbmn.delete');
            Route::post('/update', [SubMenuController::class, 'update'])->name('sbmn.update');
        });

        // Roles
        Route::prefix('roles')->group(function() {
            Route::get('/', [RoleController::class, 'index'])->name('rl.index');
            Route::get('/{id}/menus', [RoleController::class, 'view'])->name('rl.view');

            Route::post('/create', [RoleController::class, 'create'])->name('rl.create');
            Route::post('/delete', [RoleController::class, 'destroy'])->name('rl.delete');
            Route::post('/update', [RoleController::class, 'update'])->name('rl.update');
            Route::post('/menus/create', [RoleController::class, 'createMenus'])->name('rl.menus.create');
        });

        // Values
        Route::prefix('values')->group(function() {
            Route::get('/', [ValueController::class, 'index'])->name('val.index');

            Route::post('/create', [ValueController::class, 'create'])->name('val.create');
            Route::post('/delete', [ValueController::class, 'destroy'])->name('val.delete');
            Route::post('/update', [ValueController::class, 'update'])->name('val.update');
        });
    });
});

Route::middleware(Guest::class)->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('signin');
    Route::get('/register', [LoginController::class, 'add'])->name('signup');
    Route::get('/forgot', [LoginController::class, 'forgot'])->name('forgot');

    Route::post('/validate', [LoginController::class, 'validate'])->name('validate');
});

include 'api.php';
