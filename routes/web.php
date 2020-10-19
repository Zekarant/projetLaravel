<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::middleware ('admin')->group (function () {

    Route::resource ('matiere', 'MatiereController', [
        'except' => 'show'
    ]);

});

Route::middleware ('auth', 'verified')->group (function () {
    Route::resource ('cours', 'CoursController', [
        'only' => ['create', 'store', 'destroy', 'update']
    ]);
    Route::name ('cours.')->middleware ('ajax')->group (function () {
        Route::prefix('cours')->group(function () {
            Route::name ('description')->put ('{cours}/description', 'CoursController@descriptionUpdate');
        });
    });
});

Route::name ('matiere')->get ('matiere/{slug}', 'CoursController@matiere');
Route::name ('user')->get ('cours/{user}', 'CoursController@user');

