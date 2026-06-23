<?php
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Uploader\ResourceController;


use App\Http\Controllers\{
    DashboardController
    
};

use App\Http\Controllers\Uploader\UploaderViewsController;



// Web Controllers
use App\Http\Controllers\Web\{
    WebHomepageContentController,
    WebOpportunityController,
    WebLegalController,
     WebAboutController,
    WebAboutTableController,
    WebCompanyStatementController,
   
};

use App\Http\Controllers\Uploader\ProfileController;

use App\Http\Controllers\Web\General\{
    FooterController,
    SocialController,
    LogoController,
    PartnersController,
    Nav1Controller
};





// -----------------------------
// Uploader & profile CRUD routes (role:3)
// -------------------------
Route::middleware(['auth', 'role:3'])->prefix('Uploader')->name('Uploader.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'Uploader'])->name('dashboard');
    Route::view('/loading_count_down', 'loading_count_down');

   

// =========================
// STEP FLOW (RESOURCE NAVIGATION)
// =========================

Route::get('/boards', [UploaderViewsController::class, 'selectBoard'])
    ->name('home.boards');
    
    // =========================
    // STEP FLOW (RESOURCE NAVIGATION)
    // =========================

Route::get('/board/{examBoard}/years', [UploaderViewsController::class, 'selectYear'])
    ->name('select.year');

Route::get('/board/{examBoard}/year/{year}/sessions', [UploaderViewsController::class, 'selectSession'])
    ->name('select.session');

Route::get('/board/{examBoard}/year/{year}/session/{session}/programs', [UploaderViewsController::class, 'selectProgram'])
    ->name('select.program');

Route::get('/board/{examBoard}/year/{year}/session/{session}/program/{program}/courses', [UploaderViewsController::class, 'selectCourse'])
    ->name('select.course');
    
        // =========================
    // RESOURCE ACTIONS
    // =========================


Route::get('/board/{examBoard}/year/{year}/session/{session}/program/{program}/course/{course}/resources',
    [UploaderViewsController::class, 'showResources']
)->name('select.resources');

// =========================
// SAVED (BOOKMARKS)
// =========================

// Save resource
Route::post('/resource/{resource}/save', [UploaderViewsController::class, 'save'])
    ->name('home.resource.save');

// Unsave resource
Route::delete('/resource/{resource}/unsave', [UploaderViewsController::class, 'unsave'])
    ->name('home.resource.unsave');

// Saved page
Route::get('/saved', [UploaderViewsController::class, 'saved'])
    ->name('saved');


// ====================================================================
// RESOURCE MANAGEMENT (Upload & Management)
// ====================================================================
// RESOURCE UPLOAD - MULTI-STEP (NO JS)
// ====================================================================

Route::prefix('resources')->name('resources.')->group(function () {

    // =====================================================
    // CRUD
    // =====================================================

    // LIST
    Route::get('/', [ResourceController::class, 'index'])->name('index');

    // CREATE (Step 1 - Board)
    Route::get('/create', [ResourceController::class, 'create'])->name('create');

    // STORE (FINAL UPLOAD)
    Route::post('/', [ResourceController::class, 'store'])->name('store');


    // =====================================================
    // MULTI-STEP STRUCTURE FLOW
    // =====================================================

    // Step 2: Year
    Route::get('/{examBoard}/years', 
        [ResourceController::class, 'selectYear']
    )->name('years.index');

    // Step 3: Session
    Route::get('/{examBoard}/years/{boardYear}/sessions',
        [ResourceController::class, 'selectSession']
    )->name('sessions.index');

    // Step 4: Program
    Route::get('/{examBoard}/years/{boardYear}/sessions/{boardSession}/programs',
        [ResourceController::class, 'selectProgram']
    )->name('programs.index');

    // Step 5: Course
    Route::get('/{examBoard}/years/{boardYear}/sessions/{boardSession}/programs/{boardProgram}/courses',
        [ResourceController::class, 'selectCourse']
    )->name('courses.index');

    // ✅ Step 6: FINAL UPLOAD FORM (THIS WAS MISSING)
    Route::get('/{examBoard}/years/{boardYear}/sessions/{boardSession}/programs/{boardProgram}/courses/{boardCourse}/upload',
        [ResourceController::class, 'uploadForm']
    )->name('upload.form');


    // =====================================================
    // OTHER CRUD (KEEP LAST!)
    // =====================================================

    // SHOW
    Route::get('/{resource}', [ResourceController::class, 'show'])
        ->name('show');

    // DELETE
    Route::delete('/{resource}', [ResourceController::class, 'destroy'])
        ->name('destroy');

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














// ====================================================================
// ZUMHUB   WEB MANAGMENT
// ====================================================================









    // --- Homepage Content Management ---
    Route::prefix('web/homepage')->name('web.homepage.')->group(function () {
        Route::get('/content/edit', [WebHomepageContentController::class, 'edit'])->name('content.edit');
        Route::post('/content/update', [WebHomepageContentController::class, 'update'])->name('content.update');
    });

    Route::prefix('web/homepage/table')->name('web.homepage.table.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\WebHomepageContentTableController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Web\WebHomepageContentTableController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Web\WebHomepageContentTableController::class, 'store'])->name('store');
        Route::get('/{table}/edit', [\App\Http\Controllers\Web\WebHomepageContentTableController::class, 'edit'])->name('edit');
        Route::post('/{table}/update', [\App\Http\Controllers\Web\WebHomepageContentTableController::class, 'update'])->name('update');
        Route::delete('/{table}', [\App\Http\Controllers\Web\WebHomepageContentTableController::class, 'destroy'])->name('destroy');
    });


        // Company Statements
    Route::prefix('web/homepage/statements')->name('web.homepage.statements.')->group(function () {
        Route::get('/', [WebCompanyStatementController::class, 'index'])->name('index');
        Route::get('/create', [WebCompanyStatementController::class, 'create'])->name('create');
        Route::post('/store', [WebCompanyStatementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [WebCompanyStatementController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [WebCompanyStatementController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [WebCompanyStatementController::class, 'destroy'])->name('destroy');
    });

    // --- Opportunity Management ---
    Route::prefix('web/opportunities')->name('web.opportunities.')->group(function () {
        Route::get('/', [WebOpportunityController::class, 'index'])->name('index');
        Route::get('/create', [WebOpportunityController::class, 'create'])->name('create');
        Route::post('/', [WebOpportunityController::class, 'store'])->name('store');
        Route::get('/{opportunity}/edit', [WebOpportunityController::class, 'edit'])->name('edit');
        Route::put('/{opportunity}', [WebOpportunityController::class, 'update'])->name('update');
        Route::delete('/{opportunity}', [WebOpportunityController::class, 'destroy'])->name('destroy');
    });



    // --- Legal (Privacy & Terms) ---
    Route::prefix('web/legal')->name('web.legal.')->group(function () {
        Route::get('/', [WebLegalController::class, 'index'])->name('index');
        Route::get('/create', [WebLegalController::class, 'create'])->name('create');
        Route::post('/', [WebLegalController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [WebLegalController::class, 'edit'])->name('edit');
        Route::put('/{id}', [WebLegalController::class, 'update'])->name('update');
        Route::delete('/{id}', [WebLegalController::class, 'destroy'])->name('destroy');
    });

    // --- General Footer ---
    Route::prefix('web/general/footer')->name('web.general.footer.')->group(function () {
        Route::get('/titles', [FooterController::class, 'titleIndex'])->name('titles.index');
        Route::get('/titles/create', [FooterController::class, 'titleCreate'])->name('titles.create');
        Route::post('/titles/store', [FooterController::class, 'titleStore'])->name('titles.store');
        Route::get('/titles/{title}/edit', [FooterController::class, 'titleEdit'])->name('titles.edit');
        Route::put('/titles/{title}/update', [FooterController::class, 'titleUpdate'])->name('titles.update');
        Route::delete('/titles/{title}', [FooterController::class, 'titleDestroy'])->name('titles.destroy');

        Route::get('/items', [FooterController::class, 'itemIndex'])->name('items.index');
        Route::get('/items/create', [FooterController::class, 'itemCreate'])->name('items.create');
        Route::post('/items/store', [FooterController::class, 'itemStore'])->name('items.store');
        Route::get('/items/{item}/edit', [FooterController::class, 'itemEdit'])->name('items.edit');
        Route::put('/items/{item}/update', [FooterController::class, 'itemUpdate'])->name('items.update');
        Route::delete('/items/{item}', [FooterController::class, 'itemDestroy'])->name('items.destroy');
    });

    // --- General Socials ---
    Route::prefix('web/general/socials')->name('web.general.socials.')->group(function () {
        Route::get('/', [SocialController::class, 'index'])->name('index');
        Route::get('/create', [SocialController::class, 'create'])->name('create');
        Route::post('/store', [SocialController::class, 'store'])->name('store');
        Route::get('/{social}/edit', [SocialController::class, 'edit'])->name('edit');
        Route::put('/{social}', [SocialController::class, 'update'])->name('update');
        Route::delete('/{social}', [SocialController::class, 'destroy'])->name('destroy');
    });

    // --- General Logo ---
    Route::prefix('web/general/logo')->name('web.general.logo.')->group(function () {
        Route::get('/', [LogoController::class, 'index'])->name('index');
        Route::get('/create', [LogoController::class, 'create'])->name('create');
        Route::post('/store', [LogoController::class, 'store'])->name('store');
        Route::get('/{logo}/edit', [LogoController::class, 'edit'])->name('edit');
        Route::put('/{logo}/update', [LogoController::class, 'update'])->name('update');
        Route::delete('/{logo}/delete', [LogoController::class, 'destroy'])->name('destroy');
    });

    // --- General Nav1 ---
Route::prefix('web/general/nav1')->name('web.general.nav1.')->group(function () {
    Route::get('/', [Nav1Controller::class, 'index'])->name('index');
    Route::get('/create', [Nav1Controller::class, 'create'])->name('create');
    Route::post('/store', [Nav1Controller::class, 'store'])->name('store');
    Route::get('/{nav1}/edit', [Nav1Controller::class, 'edit'])->name('edit');
    Route::put('/{nav1}/update', [Nav1Controller::class, 'update'])->name('update');
    Route::delete('/{nav1}/delete', [Nav1Controller::class, 'destroy'])->name('destroy');
});


    // --- General Partners ---
    Route::prefix('web/general/partners')->name('web.general.partners.')->group(function () {
        Route::get('/', [PartnersController::class, 'index'])->name('index');
        Route::get('/create', [PartnersController::class, 'create'])->name('create');
        Route::post('/store', [PartnersController::class, 'store'])->name('store');
        Route::get('/{partner}/edit', [PartnersController::class, 'edit'])->name('edit');
        Route::put('/{partner}/update', [PartnersController::class, 'update'])->name('update');
        Route::delete('/{partner}/delete', [PartnersController::class, 'destroy'])->name('destroy');
    });



Route::prefix('web/about')->name('web.about')->group(function () {

    // Main About Content (Single Row)
    Route::prefix('/')->name('.')->group(function () {
        Route::get('/edit', [WebAboutController::class, 'edit'])->name('edit');
        Route::post('/update', [WebAboutController::class, 'update'])->name('update');
    });

    // About Table Content (Multiple Rows)
    Route::prefix('/table')->name('.table.')->group(function () {
        Route::get('/', [WebAboutTableController::class, 'index'])->name('index');
        Route::get('/create', [WebAboutTableController::class, 'create'])->name('create');
        Route::post('/store', [WebAboutTableController::class, 'store'])->name('store');
        Route::get('/edit/{table}', [WebAboutTableController::class, 'edit'])->name('edit');
        Route::post('/update/{table}', [WebAboutTableController::class, 'update'])->name('update');
        Route::delete('/delete/{table}', [WebAboutTableController::class, 'destroy'])->name('destroy');
    });

});





});
