<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', ['uses' => 'HomeController@index', 'as' => 'home']);

Route::group(['prefix' => 'posts', 'middleware' => 'auth'], function () {
    Route::get('', ['uses' => 'PostsController@index', 'as' => 'post.index']);
    Route::get('create', ['uses' => 'PostsController@criar', 'as' => 'post.create']);
    Route::post('store', ['uses' => 'PostsController@salvar', 'as' => 'post.store']);
    Route::get('edit/{id}', ['uses' => 'PostsController@editar', 'as' => 'post.edit']);
    Route::post('update/{id}', ['uses' => 'PostsController@atualizar', 'as' => 'post.update']);
    Route::get('destroy/{id}', ['uses' => 'PostsController@deletar', 'as' => 'post.destroy']);

    Route::get('filter/{status}', ['uses' => 'PostsController@filtered', 'as' => 'post.filtered']);
    Route::get('search/{status}', ['uses' => 'PostsController@filtered', 'as' => 'post.filtered']);
});
