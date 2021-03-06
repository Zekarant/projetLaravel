<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware ('admin')->group (function () {

    Route::resource ('matiere', 'MatiereController', [
        'except' => 'show'
    ]);

    Route::resource ('user', 'UserController', [
        'only' => ['index', 'edit', 'update', 'destroy']
    ]);

    Route::name ('orphans.')->prefix('orphans')->group(function () {
        Route::name ('index')->get ('/', 'AdminController@orphans');
        Route::name ('destroy')->delete ('/', 'AdminController@destroy');
    });

});

Route::middleware ('auth', 'verified')->group (function () {
    Route::resource ('cours', 'CoursController', [
        'only' => ['create', 'store', 'destroy', 'update']
    ]);
    Route::name ('cours.')->middleware ('ajax')->group (function () {
        Route::prefix('cours')->group(function () {
            Route::name ('description')->put ('{cours}/description', 'CoursController@descriptionUpdate');
        });
        Route::name ('rating')->put ('rating/{cours}', 'CoursController@rate');
        Route::name('profs')->get('{cours}/profs', 'CoursController@profs');
        Route::name ('profs.update')->put ('{cours}/profs', 'CoursController@profsUpdate');
    });
    Route::resource ('profile', 'ProfileController', [
        'only' => ['edit', 'update', 'destroy', 'show'],
        'parameters' => ['profile' => 'user']
    ]);
    Route::resource ('prof', 'ProfController', [
        'except' => 'show'
    ]);
});

Route::name ('matiere')->get ('matiere/{slug}', 'CoursController@matiere');
Route::name ('user')->get ('cours/{user}', 'CoursController@user');
Route::name ('prof')->get ('professeur/{slug}', 'CoursController@prof');

