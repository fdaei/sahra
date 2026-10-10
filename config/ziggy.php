<?php

declare(strict_types=1);

/*
| Routes exposed to the frontend through @routes and the `ziggy` shared prop.
|
| Both are inlined into every public page, so the ~60 Filament and Livewire
| admin routes only added weight to the HTML (and advertised the panel's URL
| map). The public Vue pages never resolve admin routes.
*/

return [
    'except' => [
        'filament.*',
        'livewire.*',
        'admin.*',
        'storage.*',
        'test-mail',
    ],
];
