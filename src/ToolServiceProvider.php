<?php

namespace Tipoff\StaffBookings;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Tipoff\StaffBookings\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'booking');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/booking')
            ->group(__DIR__.'/../routes/api.php');
    }
}
