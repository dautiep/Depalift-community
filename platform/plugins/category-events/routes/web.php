<?php

Route::group(['namespace' => 'Platform\CategoryEvents\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'category-events', 'as' => 'category-events.'], function () {
            Route::resource('', 'CategoryEventsController')->parameters(['' => 'category-events']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CategoryEventsController@deletes',
                'permission' => 'category-events.destroy',
            ]);
        });
    });

});
