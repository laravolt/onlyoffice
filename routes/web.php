<?php

use Illuminate\Support\Facades\Route;

Route::post('/onlyoffice-login', [\Laravolt\Onlyoffice\Controllers\OnlyofficeController::class, 'onlyofficeLogin'])->name('onlyoffice.login');
