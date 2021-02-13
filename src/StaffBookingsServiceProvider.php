<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings;

use Tipoff\StaffBookings\Models\StaffBookings;
use Tipoff\StaffBookings\Policies\StaffBookingsPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class ToolServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                StaffBookings::class => StaffBookingsPolicy::class,
            ])
            ->name('staff-bookings')
            ->hasConfigFile();
    }
}