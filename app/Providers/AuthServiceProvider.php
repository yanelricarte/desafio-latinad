<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Display;
use App\Policies\DisplayPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapeo de modelos con sus políticas.
     */
    protected $policies = [
        Display::class => DisplayPolicy::class,
    ];

    /**
     * Bootstrap de servicios de autorización.
     */
    public function boot(): void
    {
        //
    }
}
