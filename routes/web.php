<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', ['uses' => 'HomeController@index', 'as' => 'home']);

    Route::group(['prefix' => 'posts'], function () {
        Route::get('', ['uses' => 'PostsController@index', 'as' => 'post.index']);
        Route::get('create', ['uses' => 'PostsController@create', 'as' => 'post.create']);
        Route::post('store', ['uses' => 'PostsController@store', 'as' => 'post.store']);
        Route::get('edit/{id}', ['uses' => 'PostsController@edit', 'as' => 'post.edit']);
        Route::post('update/{id}', ['uses' => 'PostsController@update', 'as' => 'post.update']);
        Route::post('destroy/{id}', ['uses' => 'PostsController@destroy', 'as' => 'post.destroy']);

        Route::get('filter/{status}', ['uses' => 'PostsController@filtered', 'as' => 'post.filtered']);
        Route::get('search/{word?}', ['uses' => 'PostsController@search', 'as' => 'post.search']);
    });
});
