<?php

namespace Tipoff\StaffBookings;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\StaffBookings\StaffBookings
 */
class StaffBookingsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'staff-bookings';
    }
}
