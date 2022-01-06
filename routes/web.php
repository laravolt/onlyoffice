<?php

use Illuminate\Support\Facades\Route;

Route::post('/onlyoffice/login', [\Laravolt\OnlyOffice\Controllers\LoginController::class, 'store'])
    ->middleware('web')
    ->name('onlyoffice::login');
