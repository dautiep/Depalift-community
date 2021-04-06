<?php

Route::group(['namespace' => 'Platform\PostTraining\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'post-trainings', 'as' => 'post-training.'], function () {
            Route::resource('', 'PostTrainingController')->parameters(['' => 'post-training']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PostTrainingController@deletes',
                'permission' => 'post-training.destroy',
            ]);
        });
    });

});
