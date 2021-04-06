<?php

Route::group(['namespace' => 'Platform\LibraryCategory\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'library-categories', 'as' => 'library-category.'], function () {
            Route::resource('', 'LibraryCategoryController')->parameters(['' => 'library-category']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'LibraryCategoryController@deletes',
                'permission' => 'library-category.destroy',
            ]);
        });
    });

});
