<?php

use Modules\Language\Http\Controllers\LanguageController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function (){
    Route::resource('languages', LanguageController::class)->except('show');
});
