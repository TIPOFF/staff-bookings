<?php

namespace Tipoff\StaffBookings;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\StaffBookings\Commands\StaffBookingsCommand;

class StaffBookingsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('staff-bookings')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_staff_bookings_table')
            ->hasCommand(StaffBookingsCommand::class);
    }
}
