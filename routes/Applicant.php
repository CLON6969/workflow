<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\ApplicationController;




use App\Http\Controllers\{
    DashboardController
};


/*
|--------------------------------------------------------------------------
| Applicant ROUTES (AUTH + ROLE:4)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:4'])
    ->prefix('Applicant')
    ->name('Applicant.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'Applicant'])
            ->name('dashboard');

        Route::view('/loading_count_down', 'loading_count_down');


// =============================
            // APPLICATIONS (NEW - Assignment)
            // =============================
            Route::prefix('applications')->name('applications.')->group(function () {
                Route::get('/', [ApplicationController::class, 'index'])->name('index');
                Route::get('/create', [ApplicationController::class, 'create'])->name('create');
                Route::post('/', [ApplicationController::class, 'store'])->name('store');
                Route::get('/{application}/edit', [ApplicationController::class, 'edit'])->name('edit');
                Route::put('/{application}', [ApplicationController::class, 'update'])->name('update');
                Route::post('/{application}/submit', [ApplicationController::class, 'submit'])->name('submit');
            });


        // =============================
        // PROFILE
        // =============================
Route::prefix('profile-account')->name('profile-account.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('index');
    Route::put('/update', [ProfileController::class, 'update'])->name('update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
});



    });
