<?php

return [
    'brand' => config('app.name', 'Portal de Denúncias'),
    'default_filesystem_disk' => 'public',
    'middleware' => [
        'auth' => [\Filament\Http\Middleware\Authenticate::class],
    ],
];
