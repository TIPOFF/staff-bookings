<?php

namespace Tipoff\StaffBookings\Http\Controllers;

use Tipoff\StaffBookings\Http\Controllers\Controller;
use App\Models\Location;
use App\Transformers\LocationTransformer;

class LocationsController extends Controller
{
    public function show(Location $location)
    {
        return fractal($location, new LocationTransformer)
            ->respond();
    }
}
