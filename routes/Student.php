<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payments\ZamtelCallbackController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\StudentViewsController;


use App\Http\Controllers\{
    DashboardController
};

/*
|--------------------------------------------------------------------------
| PAYMENT CALLBACKS (PUBLIC – NO AUTH)
|--------------------------------------------------------------------------
| These routes are called by mobile money providers (Zamtel)
| Security is handled via signature + IP validation
*/
Route::post('/payments/zamtel/callback', [ZamtelCallbackController::class, 'handle'])
    ->name('payments.zamtel.callback');


/*
|--------------------------------------------------------------------------
| Student ROUTES (AUTH + ROLE:4)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:4'])
    ->prefix('Student')
    ->name('Student.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'Student'])
            ->name('dashboard');

        Route::view('/loading_count_down', 'loading_count_down');




// =========================
// STEP FLOW (RESOURCE NAVIGATION)
// =========================

Route::get('/boards', [StudentViewsController::class, 'selectBoard'])
    ->name('home.boards');
    
    // =========================
    // STEP FLOW (RESOURCE NAVIGATION)
    // =========================

Route::get('/board/{examBoard}/years', [StudentViewsController::class, 'selectYear'])
    ->name('select.year');

Route::get('/board/{examBoard}/year/{year}/sessions', [StudentViewsController::class, 'selectSession'])
    ->name('select.session');

Route::get('/board/{examBoard}/year/{year}/session/{session}/programs', [StudentViewsController::class, 'selectProgram'])
    ->name('select.program');

Route::get('/board/{examBoard}/year/{year}/session/{session}/program/{program}/courses', [StudentViewsController::class, 'selectCourse'])
    ->name('select.course');
    
        // =========================
    // RESOURCE ACTIONS
    // =========================


Route::get('/board/{examBoard}/year/{year}/session/{session}/program/{program}/course/{course}/resources',
    [StudentViewsController::class, 'showResources']
)->name('select.resources');

// =========================
// SAVED (BOOKMARKS)
// =========================

// Save resource
Route::post('/resource/{resource}/save', [StudentViewsController::class, 'save'])
    ->name('home.resource.save');

// Unsave resource
Route::delete('/resource/{resource}/unsave', [StudentViewsController::class, 'unsave'])
    ->name('home.resource.unsave');

// Saved page
Route::get('/saved', [StudentViewsController::class, 'saved'])
    ->name('saved');



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
