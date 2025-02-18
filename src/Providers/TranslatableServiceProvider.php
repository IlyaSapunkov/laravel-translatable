<?php

declare(strict_types=1);

namespace IlyaSapunkov\Translatable\Providers;

use Illuminate\Support\ServiceProvider;

class TranslatableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'translatable-migrations');
    }
}
