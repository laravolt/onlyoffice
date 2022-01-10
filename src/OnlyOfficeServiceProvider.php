<?php

namespace Laravolt\OnlyOffice;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class OnlyOfficeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'onlyoffice');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/2022_01_10_021527_create_onlyoffice_tokens_table.php');
        Blade::component('onlyoffice', OnlyOfficeComponent::class);
    }
}
