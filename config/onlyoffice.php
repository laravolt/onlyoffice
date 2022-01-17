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
        '13' => 'Template',
        '15' => 'Invoice'
        // 'template' => [
        //     'label' => '13',
        // ],
        // 'cv' => [
        //     'label' => '14'
        // ],
        // 'invoice' => [
        //     'label' => '15',
        // ]
    ],
];
