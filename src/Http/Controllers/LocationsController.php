<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings\Http\Controllers;

use Tipoff\Locations\Models\Location;
use Tipoff\Support\Http\Controllers\BaseController;

class LocationsController extends BaseController
{
    public function show(Location $location)
    {
        // TODO - import LocationTransformer
        return fractal($location) // new LocationTransformer)
            ->respond();
    }
}
