<?php

Route::group(['namespace' => 'Platform\PostProducer\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'post-producers', 'as' => 'post-producer.'], function () {
            Route::resource('', 'PostProducerController')->parameters(['' => 'post-producer']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PostProducerController@deletes',
                'permission' => 'post-producer.destroy',
            ]);
        });
    });

});
