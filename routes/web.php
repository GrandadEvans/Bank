<?php

use Bank\Http\Controllers\Auth\LoginController;
use Bank\Http\Controllers\BadgeController;
use Bank\Http\Controllers\GraphController;
use Bank\Http\Controllers\ImporterController;
use Bank\Http\Controllers\PaymentMethodController;
use Bank\Http\Controllers\PossibleRegularController;
use Bank\Http\Controllers\PredictionsController;
use Bank\Http\Controllers\ProviderController;
use Bank\Http\Controllers\RegularController;
use Bank\Http\Controllers\TagController;
use Bank\Http\Controllers\TransactionController;
use Bank\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::get('/logout', [LoginController::class, 'logout'])->name('get_logout');
Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/get-user-details', function () {
        return Auth::user();
    });

    // Home
    Route::view('/home', 'home')->name('home');

    // Graphs
    Route::prefix('/graph')->name('graphs.')->group(function () {
        Route::get('/by-tags/months/{months}', [GraphController::class, 'byTags']);
        Route::get('/totalsByMonth', [GraphController::class, 'totalsByMonth']);
    });

    // Transactions
    Route::prefix('/transactions')->name('transactions.')->group(function () {
        Route::get('/create', [TransactionController::class, 'create'])->name('create');
        Route::post('/create', [TransactionController::class, 'store'])->name('store');
        Route::get('/edit/{transaction}', [TransactionController::class, 'edit'])->name('edit');
        Route::get('/getJsonTags/{transaction}', [TransactionController::class, 'getJsonTags'])->name('getJsonTags');
        Route::put('/edit/{transaction}', [TransactionController::class, 'update'])->name('update');
        Route::put('/ajaxUpdate/{transaction}', [TransactionController::class, 'ajaxUpdate'])->name('ajaxUpdate');
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('delete');
//        Route::get('/auto_import', [TransactionController::class, 'autoImport'])->name('auto_import');
        Route::get('/import', [TransactionController::class, 'import'])->name('import');
        Route::get('/providerChoice', [TransactionController::class, 'providerChoice'])->name('providerChoice');
        Route::post('/manual_import', [TransactionController::class, 'manual_import'])->name('manual_import');
        Route::get('/all/{page?}/{limit?}/{search?}', [TransactionController::class, 'all'])->name('all');
        Route::get('/{transaction}/update_provider/{provider}', [TransactionController::class, 'updateProvider']);
        Route::delete('/{transaction}/unlink_tag/{tag}', [TransactionController::class, 'unlinkTag']);

        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/filter/{search?}', [TransactionController::class, 'filter'])->name('filter');
        Route::get('/getTransactionScrapeDates', [TransactionController::class, 'GetTransactionScrapeDates']);
        Route::get('/auto_import/', [TransactionController::class, 'autoImport']);
        Route::patch('/add-remark-from-js', [TransactionController::class, 'addRemarkFromJs']);
    });

    // Regulars
    Route::prefix('/regulars')->name('regulars.')->group(function () {
        Route::get('/', [RegularController::class, 'index'])->name('index');
        Route::get('/create', [RegularController::class, 'create'])->name('create');
        Route::post('/create_from_js', [RegularController::class, 'storeFromJs'])->name('storeFromJs');
        Route::get('/edit/{regular}', [RegularController::class, 'edit'])->name('edit');
        Route::put('/edit/{regular}', [RegularController::class, 'update'])->name('update');
        Route::delete('/{regular}', [RegularController::class, 'destroy'])->name('delete');
    });

    // PossibleRegulars
    Route::prefix('/possible-regulars')->name('possibleRegulars.')->group(function () {
        Route::get('/', [PossibleRegularController::class, 'index'])->name('index');
        Route::put('/edit/{possibleRegular}', [PossibleRegularController::class, 'update'])->name('update');
        Route::get('/scan', [PossibleRegularController::class, 'scan'])->name('scan');
        Route::get('/scan_results', [PossibleRegularController::class, 'scanResults'])->name('scanResults');
        Route::post('/accept', [PossibleRegularController::class, 'accept']);
        Route::post('/decline', [PossibleRegularController::class, 'decline']);
        Route::post('/postpone', [PossibleRegularController::class, 'postpone']);
        Route::get('/first', [PossibleRegularController::class, 'view'])->name('view'); // keep at bottom
        Route::delete('/{possibleRegular}', [PossibleRegularController::class, 'destroy'])->name('delete');
    });

    // Providers
    Route::prefix('/providers')->name('providers.')->group(function () {
        Route::get('/', [ProviderController::class, 'index'])->name('index');
        Route::get('/create', [ProviderController::class, 'create'])->name('create');
        Route::post('/store-from-js', [ProviderController::class, 'storeFromJs']);
        Route::get('/find-transactions/{provider}',
            [ProviderController::class, 'findTransactions'])->name('find-transactions');
        Route::get('/transactions/{provider}',
            [ProviderController::class, 'transactions'])->name('provider-transactions');
        Route::post('/create', [ProviderController::class, 'store'])->name('store');
        Route::get('/edit/{provider}', [ProviderController::class, 'edit'])->name('edit');
        Route::put('/edit/{provider}', [ProviderController::class, 'update'])->name('update');
        Route::delete('/{provider}', [ProviderController::class, 'destroy'])->name('delete');
        Route::post('/assignTransactions', [ProviderController::class, 'assignTransactions']);
        Route::get('/simple_list', [ProviderController::class, 'simple_list']);
    });

    // Tags
    Route::prefix('/tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/store-from-js', [TagController::class, 'storeFromJs']);
        Route::post('/associate-from-js', [TagController::class, 'associateFromJs']);
        Route::post('/create', [TagController::class, 'store'])->name('store');
        Route::get('/edit/{tag}', [TagController::class, 'edit'])->name('edit');
        Route::put('/edit/{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('/{tag}', [TagController::class, 'destroy'])->name('delete');
        Route::post('/assignTransactions', [TagController::class, 'assignTransactions']);

        Route::get('/simple_list', [TagController::class, 'simpleList']);
    });

    // Badges
    Route::prefix('/badges')->name('badges.')->group(function () {
        Route::get('/', [BadgeController::class, 'index'])->name('index');
        Route::get('/update/{route}/{action}', [BadgeController::class, 'update'])->name('update');
    });

    // Predictions
    Route::get('/predictions', [PredictionsController::class, 'index'])->name('predictions');

    Route::get('/payment_methods/all', [PaymentMethodController::class, 'all']);
});
Route::get('/transfer_statement', [ImporterController::class, 'statement_transferer']);
