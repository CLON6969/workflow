<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AcademicSetupController;
use App\Http\Controllers\Admin\{ AdminProfileController};
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminViewsController;




// Public Controllers
use App\Http\Controllers\{
    DashboardController
};




// Web Controllers
use App\Http\Controllers\Admin\Web\{
    WebHomepageContentController,
    WebHomepageContentTableController,
    WebOpportunityController,
    WebLegalController,
     WebAboutController,
    WebAboutTableController,
    WebCompanyStatementController,
   
};

use App\Http\Controllers\Admin\Web\General\{
    FooterController,
    SocialController,
    LogoController,
    PartnersController,
    Nav1Controller
};

Route::middleware(['auth', 'role:1'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::view('/loading_count_down', 'loading_count_down')->name('loading_count_down');



// ====================================================================
// Analytics
// ====================================================================


Route::prefix('analytics')->name('analytics.')->group(function () {

    // Dashboard
    Route::get('/', [AdminAnalyticsController::class, 'dashboard'])->name('dashboard');

    // resources
     Route::get('resources', [AdminAnalyticsController::class, 'resources'])->name('resources');

    // Orders Overview
    Route::get('/orders', [AdminAnalyticsController::class, 'orders'])->name('orders');

    // Customers Overview
    Route::get('/customers', [AdminAnalyticsController::class, 'customers'])->name('customers');

    // Events / Funnel Analytics
    Route::get('/events', [AdminAnalyticsController::class, 'events'])->name('events');

    // Sales by Category
    Route::get('/categories', [AdminAnalyticsController::class, 'categories'])->name('categories');

    // Refund & Alerts
    Route::get('/alerts', [AdminAnalyticsController::class, 'alerts'])->name('alerts');

});








// =========================
// STEP FLOW (RESOURCE NAVIGATION)
// =========================

Route::get('/boards', [AdminViewsController::class, 'selectBoard'])
    ->name('home.boards');
    
    // =========================
    // STEP FLOW (RESOURCE NAVIGATION)
    // =========================

Route::get('/board/{examBoard}/years', [AdminViewsController::class, 'selectYear'])
    ->name('select.year');

Route::get('/board/{examBoard}/year/{year}/sessions', [AdminViewsController::class, 'selectSession'])
    ->name('select.session');

Route::get('/board/{examBoard}/year/{year}/session/{session}/programs', [AdminViewsController::class, 'selectProgram'])
    ->name('select.program');

Route::get('/board/{examBoard}/year/{year}/session/{session}/program/{program}/courses', [AdminViewsController::class, 'selectCourse'])
    ->name('select.course');
    
        // =========================
    // RESOURCE ACTIONS
    // =========================


Route::get('/board/{examBoard}/year/{year}/session/{session}/program/{program}/course/{course}/resources',
    [AdminViewsController::class, 'showResources']
)->name('select.resources');

// =========================
// SAVED (BOOKMARKS)
// =========================

// Save resource
Route::post('/resource/{resource}/save', [AdminViewsController::class, 'save'])
    ->name('home.resource.save');

// Unsave resource
Route::delete('/resource/{resource}/unsave', [AdminViewsController::class, 'unsave'])
    ->name('home.resource.unsave');

// Saved page
Route::get('/saved', [AdminViewsController::class, 'saved'])
    ->name('saved');




/* -------------------------------
| 👥 USER MANAGEMENT
--------------------------------*/



Route::prefix('users')->name('users.')->group(function () {

    // ✅ List all users
    Route::get('/', [UserController::class, 'index'])->name('index');

    // ✅ Create new user
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');

    // ✅ View single user
    Route::get('/{user}', [UserController::class, 'show'])->name('show');

    // ✅ Edit existing user
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');

    // ✅ Delete user
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

    // ✅ Restore deleted user
    Route::post('/{user}/restore', [UserController::class, 'restore'])->name('restore');

    // ✅ Update account status
    Route::post('/{user}/status', [UserController::class, 'updateStatus'])->name('updateStatus');

    // ✅ Update user role
    Route::post('/{user}/role', [UserController::class, 'updateRole'])->name('updateRole');

    // ✅ Manage sub-accounts
    Route::get('/{user}/sub-accounts', [UserController::class, 'subAccounts'])->name('subAccounts');

    // ✅ Manage user's orders (buyer)
    Route::get('/{user}/orders', [UserController::class, 'orders'])->name('orders');

    // ✅ Manage user's products (seller)
    Route::get('/{user}/products', [UserController::class, 'products'])->name('products');

    // ✅ Manage user's reviews
    Route::get('/{user}/reviews', [UserController::class, 'reviews'])->name('reviews');

    // ✅ Manage user's messages
    Route::get('/{user}/messages', [UserController::class, 'messages'])->name('messages');

    // ✅ Delete a user's product
    Route::delete('/{user}/products/{product}', [UserController::class, 'deleteProduct'])->name('deleteProduct');

    // ✅ Delete a user's review
    Route::delete('/{user}/reviews/{review}', [UserController::class, 'deleteReview'])->name('deleteReview');

    // ✅ Delete a user's message
    Route::delete('/{user}/messages/{message}', [UserController::class, 'deleteMessage'])->name('deleteMessage');

});


/*
|--------------------------------------------------------------------------
| ACADEMIC STRUCTURE SETUP ROUTES
|--------------------------------------------------------------------------
| Boards → Years → Sessions → Programs → Courses
| Fully CRUD enabled
|--------------------------------------------------------------------------
*/

Route::prefix('setup')->name('setup.')->group(function () {

    // ============================================================
    // DASHBOARD
    // ============================================================
    Route::get('/', [AcademicSetupController::class, 'index'])
        ->name('index');

    // ============================================================
    // BOARDS
    // ============================================================
    Route::prefix('boards')->name('boards.')->group(function () {

        Route::get('/', [AcademicSetupController::class, 'boards'])->name('index');
        Route::get('/create', [AcademicSetupController::class, 'createBoard'])->name('create');
        Route::post('/', [AcademicSetupController::class, 'storeBoard'])->name('store');

        Route::get('/{examBoard}/edit', [AcademicSetupController::class, 'editBoard'])->name('edit');
        Route::put('/{examBoard}', [AcademicSetupController::class, 'updateBoard'])->name('update');
        Route::delete('/{examBoard}', [AcademicSetupController::class, 'deleteBoard'])->name('delete');

        // ========================================================
        // YEARS (Board → Year)
        // ========================================================
        Route::prefix('{examBoard}/years')->name('years.')->group(function () {

            Route::get('/', [AcademicSetupController::class, 'years'])->name('index');
            Route::get('/create', [AcademicSetupController::class, 'createYear'])->name('create');
            Route::post('/', [AcademicSetupController::class, 'storeYear'])->name('store');

            Route::get('/{boardYear}/edit', [AcademicSetupController::class, 'editYear'])->name('edit');
            Route::put('/{boardYear}', [AcademicSetupController::class, 'updateYear'])->name('update');
            Route::delete('/{boardYear}', [AcademicSetupController::class, 'deleteYear'])->name('destroy');

            // ====================================================
            // SESSIONS (Year → Session)
            // ====================================================
            Route::prefix('{boardYear}/sessions')->name('sessions.')->group(function () {

                Route::get('/', [AcademicSetupController::class, 'sessions'])->name('index');
                Route::get('/create', [AcademicSetupController::class, 'createSession'])->name('create');
                Route::post('/', [AcademicSetupController::class, 'storeSession'])->name('store');

                Route::get('/{boardSession}/edit', [AcademicSetupController::class, 'editSession'])->name('edit');
                Route::put('/{boardSession}', [AcademicSetupController::class, 'updateSession'])->name('update');
                Route::delete('/{boardSession}', [AcademicSetupController::class, 'deleteSession'])->name('destroy');

                // ================================================
                // PROGRAMS (Session → Program)
                // ================================================
                Route::prefix('{boardSession}/programs')->name('programs.')->group(function () {

                    Route::get('/', [AcademicSetupController::class, 'programs'])->name('index');
                    Route::get('/create', [AcademicSetupController::class, 'createProgram'])->name('create');
                    Route::post('/', [AcademicSetupController::class, 'storeProgram'])->name('store');

                    Route::get('/{boardProgram}/edit', [AcademicSetupController::class, 'editProgram'])->name('edit');
                    Route::put('/{boardProgram}', [AcademicSetupController::class, 'updateProgram'])->name('update');
                    Route::delete('/{boardProgram}', [AcademicSetupController::class, 'deleteProgram'])->name('destroy');

                    // ============================================
                    // COURSES (Program → Course)
                    // ============================================
                    Route::prefix('{boardProgram}/courses')->name('courses.')->group(function () {

                        Route::get('/', [AcademicSetupController::class, 'courses'])->name('index');
                        Route::get('/create', [AcademicSetupController::class, 'createCourse'])->name('create');
                        Route::post('/', [AcademicSetupController::class, 'storeCourse'])->name('store');

                        Route::get('/{boardCourse}/edit', [AcademicSetupController::class, 'editCourse'])->name('edit');
                        Route::put('/{boardCourse}', [AcademicSetupController::class, 'updateCourse'])->name('update');
                        Route::delete('/{boardCourse}', [AcademicSetupController::class, 'deleteCourse'])->name('destroy');

                    });

                });

            });

        });

    });

});


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
    // Applicant profile CRUD (user table)
Route::prefix('profile-account')->name('profile-account.')->group(function () {
    Route::get('/', [AdminProfileController::class, 'edit'])->name('index');
    Route::put('/update', [AdminProfileController::class, 'update'])->name('update');
    Route::put('/password', [AdminProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/delete', [AdminProfileController::class, 'destroy'])->name('destroy');
});


/*
|--------------------------------------------------------------------------
| Web Management Routes
|--------------------------------------------------------------------------
|
|
*/


    // --- Homepage Content Management ---
    Route::prefix('web/homepage')->name('web.homepage.')->group(function () {
        Route::get('/content/edit', [WebHomepageContentController::class, 'edit'])->name('content.edit');
        Route::post('/content/update', [WebHomepageContentController::class, 'update'])->name('content.update');
    });

    Route::prefix('web/homepage/table')->name('web.homepage.table.')->group(function () {
        Route::get('/', [WebHomepageContentTableController::class, 'index'])->name('index');
        Route::get('/create', [WebHomepageContentTableController::class, 'create'])->name('create');
        Route::post('/store', [WebHomepageContentTableController::class, 'store'])->name('store');
        Route::get('/{table}/edit', [WebHomepageContentTableController::class, 'edit'])->name('edit');
        Route::post('/{table}/update', [WebHomepageContentTableController::class, 'update'])->name('update');
        Route::delete('/{table}', [WebHomepageContentTableController::class, 'destroy'])->name('destroy');
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
