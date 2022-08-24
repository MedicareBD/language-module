<?php

use Modules\Language\Http\Controllers\LanguageController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function (){
    Route::post('languages/sync/{language}', [LanguageController::class, 'sync'])->name('languages.sync');
    Route::resource('languages', LanguageController::class)->except('show');
});
