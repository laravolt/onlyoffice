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
        $this->menu();
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'onlyoffice');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/2022_01_10_021527_create_onlyoffice_tokens_table.php');
        Blade::component('onlyoffice', OnlyOfficeComponent::class);
    }

    protected function menu()
    {
        app('laravolt.menu.sidebar')->register(function ($menu) {
            $menu = $menu->system;
            $group = $menu->add(__('OnlyOffice'))
                ->data('icon', 'list')
                ->data('order', 1);
                // ->data('permission', config('laravolt.lookup.permission'));

            foreach (config('laravolt.lookup.collections') as $key => $collection) {
                $menu = $group->add($collection['label'], url("lookup/{$key}"))
                    ->active('lookup/'.$key.'/*');
                foreach ($collection['data'] ?? [] as $dataKey => $dataValue) {
                    $menu->data($dataKey, $dataValue);
                }
            }
        });
    }
}
