<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings;

use Tipoff\StaffBookings\Models\StaffBooking;
use Tipoff\StaffBookings\Policies\StaffBookingPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class ToolServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                StaffBookings::class => StaffBookingPolicy::class,
            ])
            ->name('staff-bookings')
            ->hasConfigFile();
    }
}