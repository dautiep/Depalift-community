<?php

Route::group(['namespace' => 'Platform\LibraryDocument\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'library-documents', 'as' => 'library-document.'], function () {
            Route::resource('', 'LibraryDocumentController')->parameters(['' => 'library-document']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'LibraryDocumentController@deletes',
                'permission' => 'library-document.destroy',
            ]);
        });
    });

});
