<?php

use Illuminate\Support\Facades\Route;
use Laravolt\OnlyOffice\Controllers\TemplateController;

Route::post('/onlyoffice/login', [\Laravolt\OnlyOffice\Controllers\LoginController::class, 'store'])
    ->middleware('web')
    ->name('onlyoffice::login');
// Route::get('/{id}/template', [TemplateController::class, 'index']);

Route::group([
    'prefix' => config('laravolt.onlyoffice.routes.prefix'),
    'as' => 'onlyoffice::',
    'middleware' => config('laravolt.onlyoffice.routes.middleware'),
],
function () {
    Route::resource('/{id}/template', TemplateController::class);
});
