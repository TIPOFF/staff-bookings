<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Addresses\AddressesServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Checkout\CheckoutServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\StaffBookings\ToolServiceProvider;
use Tipoff\Statuses\StatusesServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;
use Tipoff\TestSupport\Providers\NovaPackageServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            AuthorizationServiceProvider::class,
            PermissionServiceProvider::class,
            CheckoutServiceProvider::class,
            StatusesServiceProvider::class,
            AddressesServiceProvider::class,
            LocationsServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaPackageServiceProvider::class,
            ToolServiceProvider::class,
        ];
    }
}
