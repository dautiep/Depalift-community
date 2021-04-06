<?php

Route::group(['namespace' => 'Platform\CategoryAssociates\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'category-associates', 'as' => 'category-associates.'], function () {
            Route::resource('', 'CategoryAssociatesController')->parameters(['' => 'category-associates']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CategoryAssociatesController@deletes',
                'permission' => 'category-associates.destroy',
            ]);
        });
    });

});
