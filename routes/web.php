<?php

use Illuminate\Support\Facades\Route;

Route::post('/onlyoffice-login', [\Laravolt\Onlyoffice\Controllers\OnlyofficeController::class, 'onlyofficeLogin'])
    ->middleware('web')
    ->name('onlyoffice.login');
