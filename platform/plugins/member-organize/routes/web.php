<?php

Route::group(['namespace' => 'Platform\MemberOrganize\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'member-organizes', 'as' => 'member-organize.'], function () {
            Route::resource('', 'MemberOrganizeController')->parameters(['' => 'member-organize']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'MemberOrganizeController@deletes',
                'permission' => 'member-organize.destroy',
            ]);
        });
    });

});
