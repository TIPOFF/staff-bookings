<?php

namespace Tipoff\StaffBookings\Commands;

use Illuminate\Console\Command;

class StaffBookingsCommand extends Command
{
    public $signature = 'staff-bookings';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
