<?php

Route::group(['namespace' => 'Platform\CategoryTraining\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'category-trainings', 'as' => 'category-training.'], function () {
            Route::resource('', 'CategoryTrainingController')->parameters(['' => 'category-training']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'CategoryTrainingController@deletes',
                'permission' => 'category-training.destroy',
            ]);
        });
    });

});
