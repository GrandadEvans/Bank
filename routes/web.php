<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::view('/', 'welcome');

Route::get('/logout', 'Auth\LoginController@logout')->name('get_logout');
Auth::routes();

Route::middleware(['auth'])->group(function() {

    Route::get('/graph/by-tags/months/{months}', 'GraphController@byTags');
    Route::get('/graph/totalsByMonth', 'GraphController@totalsByMonth');

    // Home
    Route::view('/home', 'home')->name('home');

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/create', 'TransactionController@create')->name('create');
        Route::post('/create', 'TransactionController@store')->name('store');
        Route::get('/edit/{transaction}', 'TransactionController@edit')->name('edit');
        Route::get('/getJsonTags/{transaction}', 'TransactionController@getJsonTags')->name('getJsonTags');
        Route::put('/edit/{transaction}', 'TransactionController@update')->name('update');
        Route::put('/ajaxUpdate/{transaction}', 'TransactionController@ajaxUpdate')->name('ajaxUpdate');
        Route::delete('/{transaction}', 'TransactionController@destroy')->name('delete');
//        Route::get('/auto_import', 'TransactionController@autoImport')->name('auto_import');
        Route::get('/import', 'TransactionController@import')->name('import');
        Route::get('/providerChoice', 'TransactionController@providerChoice')->name('providerChoice');
        Route::post('/manual_import', 'TransactionController@manual_import')->name('manual_import');
        Route::get('/all/{page?}/{limit?}', 'TransactionController@all')->name('all');
        Route::get('/{transaction}/update_provider/{provider}', 'TransactionController@updateProvider');
        Route::get('/{transaction}/unlink_tag/{tag}', 'TransactionController@unlinkTag');

        Route::get('/', 'TransactionController@index')->name('index');
        Route::get('/filter/{search?}', 'TransactionController@filter')->name('filter');
        Route::get('/getTransactionScrapeDates', 'TransactionController@GetTransactionScrapeDates');
        Route::get('/auto_import/', 'TransactionController@autoImport');
        Route::post('/add-remark-from-js', 'TransactionController@addRemarkFromJs');
    });

    // Regulars
    Route::prefix('regulars')->name('regulars.')->group(function () {
            Route::get('/', 'RegularController@index')->name('index');
            Route::get('/create', 'RegularController@create')->name('create');
            Route::post('/create', 'RegularController@store')->name('store');
            Route::get('/edit/{regular}', 'RegularController@edit')->name('edit');
            Route::put('/edit/{regular}', 'RegularController@update')->name('update');
            Route::delete('/{regular}', 'RegularController@destroy')->name('delete');
        });

    // Providers
    Route::prefix('providers')->name('providers.')->group(function () {
        Route::get('/', 'ProviderController@index')->name('index');
        Route::get('/create', 'ProviderController@create')->name('create');
        Route::post('/store-from-js', 'ProviderController@storeFromJs');
        Route::get('/find-transactions/{provider}', 'ProviderController@findTransactions')->name('find-transactions');
        Route::get('/transactions/{provider}', 'ProviderController@transactions')->name('provider-transactions');
        Route::post('/create', 'ProviderController@store')->name('store');
        Route::get('/edit/{provider}', 'ProviderController@edit')->name('edit');
        Route::put('/edit/{provider}', 'ProviderController@update')->name('update');
        Route::delete('/{provider}', 'ProviderController@destroy')->name('delete');
        Route::get('/simple_list', 'ProviderController@simple_list');
    });

    // Tags
    Route::prefix('tags')->name('tags.')->group(function () {
            Route::get('/', 'TagController@index')->name('index');
            Route::get('/create', 'TagController@create')->name('create');
            Route::post('/store-from-js', 'TagController@storeFromJs');
            Route::post('/associate-from-js', 'TagController@associateFromJs');
            Route::post('/create', 'TagController@store')->name('store');
            Route::get('/edit/{tag}', 'TagController@edit')->name('edit');
            Route::put('/edit/{tag}', 'TagController@update')->name('update');
            Route::delete('/{tag}', 'TagController@destroy')->name('delete');
            Route::post('/assignTransactions', 'TagController@assignTransactions');
            Route::get('/simple_list', 'TagController@simpleList');
        });

    // Predictions
    Route::get('predictions', 'PredictionsController@index')->name('predictions');

    Route::get('/payment_methods/all', 'PaymentMethodController@all');

    Route::post('/search', 'SearchController@search')->name('search');
});
Route::get('/transfer_statement', 'ImporterController@statement_transferer');
