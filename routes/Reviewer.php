<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reviewer\UserController;
use App\Http\Controllers\Reviewer\ReviewerProfileController;
use App\Http\Controllers\Reviewer\ReviewController;

// Public Controllers
use App\Http\Controllers\{
    DashboardController
};

// Web Controllers (your existing)
use App\Http\Controllers\Reviewer\Web\{
    WebHomepageContentController,
    WebHomepageContentTableController,
    WebOpportunityController,
    WebLegalController,
    WebAboutController,
    WebAboutTableController,
    WebCompanyStatementController,
};

use App\Http\Controllers\Reviewer\Web\General\{
    FooterController,
    SocialController,
    LogoController,
    PartnersController,
    Nav1Controller
};

Route::middleware(['auth', 'role:1'])->prefix('Reviewer')->name('Reviewer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'Reviewer'])->name('dashboard');
    Route::view('/loading_count_down', 'loading_count_down')->name('loading_count_down');

    // =============================
    // APPLICATION REVIEW (Assignment)
    // =============================
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::get('/queue', [ReviewController::class, 'index'])->name('queue');
        Route::get('/{application}', [ReviewController::class, 'show'])->name('show');
        Route::post('/{application}/review', [ReviewController::class, 'review'])->name('review');
    });

    // Profile
    Route::prefix('profile-account')->name('profile-account.')->group(function () {
        Route::get('/', [ReviewerProfileController::class, 'edit'])->name('index');
        Route::put('/update', [ReviewerProfileController::class, 'update'])->name('update');
        Route::put('/password', [ReviewerProfileController::class, 'updatePassword'])->name('password.update');
        Route::delete('/delete', [ReviewerProfileController::class, 'destroy'])->name('destroy');
    });

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
