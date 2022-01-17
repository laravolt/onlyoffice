<?php

namespace Laravolt\OnlyOffice;

use Illuminate\Support\Facades\Blade;
use Laravolt\OnlyOffice\TableView\TemplateTableView;
use Laravolt\Support\Base\BaseServiceProvider;
use Livewire\Livewire;

class OnlyOfficeServiceProvider extends BaseServiceProvider
{
    public function getIdentifier()
    {
        return 'onlyoffice';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/2022_01_10_021527_create_onlyoffice_tokens_table.php');
        Blade::component('onlyoffice', OnlyOfficeComponent::class);
        Livewire::component('template-table', TemplateTableView::class);
    }

    protected function menu()
    {
        app('laravolt.menu.sidebar')->register(function ($menu) {
            $menu = $menu->system;
            $group = $menu->add(__('OnlyOffice'))
                ->data('icon', 'file-alt')
                ->data('order', 1);
                // ->data('permission', config('laravolt.lookup.permission'));

            foreach (config('laravolt.onlyoffice.collections') as $key => $collection) {
                // dd($key, $collection);
                $menu = $group->add($collection, url($key . '/' . lcfirst($collection)))
                    ->active($key.'/*');
                foreach ($collection['data'] ?? [] as $dataKey => $dataValue) {
                    $menu->data($dataKey, $dataValue);
                }
            }
        });
    }
}
