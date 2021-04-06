<?php

Route::group(['namespace' => 'Platform\PostEvents\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'post-events', 'as' => 'post-events.'], function () {
            Route::resource('', 'PostEventsController')->parameters(['' => 'post-events']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PostEventsController@deletes',
                'permission' => 'post-events.destroy',
            ]);
        });
    });

});
