<?php

use Illuminate\Support\Facades\Route;

Route::post('/onlyoffice-login', [\Laravolt\OnlyOffice\Controllers\OnlyOfficeController::class, 'onlyOfficeLogin'])
    ->middleware('web')
    ->name('onlyoffice.login');
