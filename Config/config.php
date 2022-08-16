<?php

return [
    'name' => 'Language',

    'menus' => [
        [
            'text' => 'Settings',
            'icon' => 'fas fa-cogs',
            'can' => 'settings-read',
            'order' => 100,
            'submenu' => [
                [
                    'text'      => 'Languages',
                    'route'     => 'admin.languages.index',
                    'can'       => 'languages-read',
                    'order' => 100,
                ],
            ]
        ]
    ],
];
