<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings;

use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class ToolServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('staff-bookings')
            ->hasConfigFile();
    }
}
