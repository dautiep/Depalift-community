<?php

Route::group(['namespace' => 'Platform\PostAssociates\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'post-associates', 'as' => 'post-associates.'], function () {
            Route::resource('', 'PostAssociatesController')->parameters(['' => 'post-associates']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PostAssociatesController@deletes',
                'permission' => 'post-associates.destroy',
            ]);
        });
    });

});
