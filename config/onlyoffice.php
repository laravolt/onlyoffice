<?php

return [
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
        'prefix' => '',
    ],
    'view' => [
        'layout' => 'laravolt::layouts.app',
    ],
    'menu' => [
        'enabled' => true,
    ],
    'collections' => [
        config()->get('services.onlyoffice.template_folder_id') => 'Template',
    ],
];
