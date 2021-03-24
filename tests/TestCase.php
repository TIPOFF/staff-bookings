<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Tests;

use DrewRoberts\Media\MediaServiceProvider;
use Laravel\Nova\NovaCoreServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Addresses\AddressesServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Checkout\CheckoutServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\Seo\SeoServiceProvider;
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
            NovaCoreServiceProvider::class,
            NovaPackageServiceProvider::class,
            SupportServiceProvider::class,
            PermissionServiceProvider::class,
            AuthorizationServiceProvider::class,
            AddressesServiceProvider::class,
            MediaServiceProvider::class,
            SeoServiceProvider::class,
            LocationsServiceProvider::class,
            StatusesServiceProvider::class,
            CheckoutServiceProvider::class,
            ToolServiceProvider::class,
        ];
    }
}
