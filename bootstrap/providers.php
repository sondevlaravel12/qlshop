<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\TenancyServiceProvider::class, // <-- here
    Mccarlosen\LaravelMpdf\LaravelMpdfServiceProvider::class,

];
