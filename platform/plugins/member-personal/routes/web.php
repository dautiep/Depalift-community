<?php

Route::group(['namespace' => 'Platform\MemberPersonal\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'member-personals', 'as' => 'member-personal.'], function () {
            Route::resource('', 'MemberPersonalController')->parameters(['' => 'member-personal']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'MemberPersonalController@deletes',
                'permission' => 'member-personal.destroy',
            ]);
        });
    });

});
