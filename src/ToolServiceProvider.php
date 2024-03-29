<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Tipoff\StaffBookings\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'booking');

        $this->app->booted(function () {
            $this->routes();
        });

        /*
        Nova::serving(function (ServingNova $event) {
        });
        */
    }

    protected function routes()
    {
        /** @psalm-suppress UndefinedInterfaceMethod */
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/booking')
                ->group(__DIR__.'/../routes/api.php');
    }

    public function register()
    {
        Nova::tools([
            new StaffBookings(),
        ]);
    }
}
