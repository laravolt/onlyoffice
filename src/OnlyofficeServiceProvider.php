<?php

namespace Laravolt\Onlyoffice;

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
        Blade::component('onlyoffice', OnlyofficeComponent::class);
    }
}
